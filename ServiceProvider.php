<?php namespace Laradic\Support;

/**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package        Radic/Dev
 * @author         Robin Radic
 * @license        MIT
 * @copyright  (c) 2011-2015, Robin Radic
 * @link           http://radic.mit-license.org
 */
use App;
use Exception;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * ServiceProvider
 *
 * @package     Laradic\Support
 *
 */
abstract class ServiceProvider extends BaseServiceProvider
{

    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;


    /**
     * Array of configuration files
     *
     * @var array
     */
    protected $configFiles = [];

    /** @var string */
    protected $dir;

    /**
     * Path to resources folder, relative to $dir
     * @var string
     */
    protected $resourcesPath = '/resources';

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var array
     */
    protected $aliases = [];

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var array
     */
    protected $prependMiddlewares = [];

    /**
     * @var array
     */
    protected $routeMiddlewares = [];


    /**
     * Boots the service provider.
     *
     * @return void
     * @throws Exception if property $dir is not set
     */
    public function boot()
    {

        if ( isset($this->dir) and isset($this->configFiles) and is_array($this->configFiles) )
        {
            foreach ($this->configFiles as $fileName)
            {
                $configPath = $this->dir . $this->resourcesPath . '/config/' . $fileName . '.php';
                $this->publishes([$configPath => config_path($fileName . '.php')], 'config');
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        $router = $app->make('router');
        $kernel = $app->make('Illuminate\Contracts\Http\Kernel');


        if ( isset($this->dir) )
        {
            foreach ($this->configFiles as $fileName)
            {
                $configPath = $this->dir . $this->resourcesPath . '/config/' . $fileName . '.php';
                $this->mergeConfigFrom($configPath, $fileName);
            }
        }

        foreach ($this->prependMiddlewares as $middleware)
        {
            $kernel->prependMiddleware($middleware);
        }

        foreach ($this->middlewares as $middleware)
        {
            $kernel->pushMiddleware($middleware);
        }

        foreach ($this->routeMiddlewares as $key => $middleware)
        {
            $router->middleware($key, $middleware);
        }

        foreach ($this->providers as $provider)
        {
            $app->register($provider);
        }

        foreach ($this->aliases as $alias => $full)
        {
            $this->alias($alias, $full);
        }
    }

    /**
     * registerProvider
     *
     * @deprecated
     * @param $str
     */
    public function registerProvider($str)
    {
        $this->app->register($str);
    }

    protected function alias($name, $fullyQualifiedName)
    {
        AliasLoader::getInstance()->alias($name, $fullyQualifiedName);
    }
}
