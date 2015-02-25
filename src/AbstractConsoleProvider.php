<?php namespace Radic\Support;

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
use ErrorException;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
/**
 * ServiceProvider
 *
 * @package Radic\Support${NAME}
 */
abstract class AbstractConsoleProvider extends BaseServiceProvider
{


    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The namespace where the commands are
     *
     * @var string
     */
    protected $namespace;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $errorMsg = "Your ConsoleServiceProvider(AbstractConsoleProvider) requires property";
        if (!isset($this->namespace) or !is_string($this->namespace))
        {
            throw new ErrorException("$errorMsg \$namespace to be an string");
        }
        if (!isset($this->commands) or !is_array($this->commands))
        {
            throw new ErrorException("$errorMsg \$commands to be an array");
        }

        $bindings = [];
        foreach ($this->commands as $command => $binding)
        {
            $bindings[] = $binding;
            $this->{"registerCommand"}($command, $binding);
        }

        $this->commands($bindings);
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerCommand($command, $binding)
    {
        $class = '\\' . $this->namespace . '\\' . $command . 'Command';
        if (!class_exists($class))
        {
            throw new ErrorException("Your ConsoleServiceProvider(AbstractConsoleProvider)->registerCommand($command, $binding) could not find $class");
        }
        $this->app->singleton($binding, function ($app) use ($class)
        {
            return new $class($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_values($this->commands);
    }
}
