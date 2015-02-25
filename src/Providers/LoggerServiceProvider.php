<?php namespace Radic\Support\Providers;

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
use Radic\Support\Logger\Factory;

/**
 * ServiceProvider
 *
 * @package Radic\Support${NAME}
 */
class LoggerServiceProvider extends ServiceProvider
{
    /** @inheritdoc */
    public function register()
    {
        $app = $this->app;
        $app->bind('radic.logger', 'Radic\Support\Logger\Factory');
        AliasLoader::getInstance()->alias('Logger', 'Radic\Support\Facades\Logger');
    }


    public function provides()
    {
        return array('radic.logger');
    }
}
