<?php namespace Laradic\Support\Traits;

/**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package        dev9
 * @author         Robin Radic
 * @license        MIT
 * @copyright  (c) 2011-2015, Robin Radic
 * @link           http://radic.mit-license.org
 */
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Symfony\Component\Finder\Finder;
/**
 * BindLaravelCoreTrait
 *
 * @package Laradic\Support\Traits${NAME}
 */
trait BindIlluminateTrait
{
    protected $illuminateConfigPath;
    protected $illuminateLangPath;
    /**
     * Bind the core classes to the Container
     *
     * @param  Container $app
     *
     * @return Container
     */
    public function bindIlluminateCore(Container $app = null)
    {
        if (!$app)
        {
            $app = new Container();
        }
        elseif ($app->bound('events'))
        {
            return $app;
        }


        //////////////////////////////////////////////////////////////////
        // Core classes
        //////////////////////////////////////////////////////////////////
        $app->bindIf('files', 'Illuminate\Filesystem\Filesystem');
        $app->bindIf('url', 'Illuminate\Routing\UrlGenerator');


        //////////////////////////////////////////////////////////////////
        // Session and request
        //////////////////////////////////////////////////////////////////
        $app->bindIf('session.manager', function ($app)
        {
            return new SessionManager($app);
        });
        $app->bindIf('session', function ($app)
        {
            return $app['session.manager']->driver('array');
        }, true);
        $app->bindIf('request', function ($app)
        {
            $request = Request::createFromGlobals();
            if (method_exists($request, 'setSessionStore'))
            {
                $request->setSessionStore($app['session']);
            }
            else
            {
                $request->setSession($app['session']);
            }

            return $request;
        }, true);


        //////////////////////////////////////////////////////////////////
        // Config
        //////////////////////////////////////////////////////////////////
        $app->bindIf('path.config', function ($app)
        {
            return $this->illuminateConfigPath;
        }, true);
        $app->bindIf('config', function ($app)
        {
            $config = new Repository;
            $this->loadIlluminateConfig($app, $config);

            return $config;
        }, true);


        //////////////////////////////////////////////////////////////////
        // Localization
        //////////////////////////////////////////////////////////////////
        $app->bindIf('translation.loader', function ($app)
        {
            return new FileLoader($app['files'], 'src/config');
        });
        $app->bindIf('translator', function ($app)
        {
            $loader = new FileLoader($app['files'], 'lang');

            return new Translator($loader, 'en');
        });

        return $app;
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param  Container $app
     * @param  Repository $config
     * @return void
     */
    protected function loadIlluminateConfig($app, Repository $config)
    {
        foreach ($this->getIlluminateConfig($app) as $key => $path)
        {
            $config->set($key, require $path);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  $app
     * @return array
     */
    protected function getIlluminateConfig($app)
    {
        $files = array();
        foreach (Finder::create()->files()->name('*.php')->in($app['path.config']) as $file)
        {
            $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }
}
