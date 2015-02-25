<?php namespace Laradic\Support\Providers;

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
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Laradic\Support\Logger\Factory;

/**
 * ServiceProvider
 *
 * @package Laradic\Support${NAME}
 */
class LoggerServiceProvider extends ServiceProvider
{
    /** @inheritdoc */
    public function register()
    {
        $app = $this->app;
        $app->bind('radic.logger', 'Laradic\Support\Logger\Factory');
        AliasLoader::getInstance()->alias('Logger', 'Laradic\Support\Facades\Logger');
    }


    public function provides()
    {
        return array('radic.logger');
    }
}
