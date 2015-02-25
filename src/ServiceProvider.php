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
 */
abstract class ServiceProvider extends BaseServiceProvider
{

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
     */
    public function boot()
    {

        if (!isset($this->dir))
        {
            throw new Exception('Service provider $dir property not set. Is required..');
        }
        foreach ($this->configFiles as $fileName)
        {
            $configPath = $this->dir . '/../config/' . $fileName . '.php';
            $this->publishes([$configPath => config_path($fileName . '.php')], 'config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (!isset($this->dir))
        {
            throw new Exception('Service provider $dir property not set. Is required..');
        }
        foreach ($this->configFiles as $fileName)
        {
            $configPath = $this->dir . '/../config/' . $fileName . '.php';
            $this->mergeConfigFrom($configPath, $fileName);
        }
    }

    /**
     * Registers a service provider
     * @param string $className    The fully qualified class name
     * @param bool $override       Default is false, If true, it will override any
     * @param bool $throwException Default is true, If false, it will now throw an exception if the class could not be found
     * @throws Exception if the className could not be found, it will throw an exception
     */
    protected function registerProvider($className, $override = false, $throwException = true)
    {
        if (class_exists($className) === true)
        {
            if ($override === true)
            {
                $this->app->register(new $className($this->app));
            }
            elseif (array_key_exists($className, App::getLoadedProviders()) === false)
            {
                $this->app->register(new $className($this->app));
            }
        }
        elseif ($throwException === true)
        {
            throw new Exception('Laradic\Support\ServiceProvider->registerProvider could not find class to register: ' . $className);
        }
    }

    protected function alias($name, $fullyQualifiedName)
    {
        AliasLoader::getInstance()->alias($name, $fullyQualifiedName);
    }
}
