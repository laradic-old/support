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
 * @package Laradic\Support${NAME}
 * @uses        \IdeHelper\ServiceProvider
 * @uses        \IdeHelper\App
 */
abstract class ServiceProvider extends BaseServiceProvider
{

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;


    /**
     * Array of configuration files
     * @var array
     */
    protected $configFiles = [];

    /** @var string */
    protected $dir;

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
                $configPath = $this->dir . '/../config/' . $fileName . '.php';
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
        if ( isset($this->dir) and isset($this->configFiles) and is_array($this->configFiles) )
        {
            foreach ($this->configFiles as $fileName)
            {
                $configPath = $this->dir . '/../config/' . $fileName . '.php';
                $this->mergeConfigFrom($configPath, $fileName);
            }
        }
    }

    public function registerProvider($str){
        $this->app->register($str);
    }
    protected function alias($name, $fullyQualifiedName)
    {
        AliasLoader::getInstance()->alias($name, $fullyQualifiedName);
    }
}
