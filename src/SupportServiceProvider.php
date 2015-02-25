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
use Laradic\Support\Logger\Factory;

/**
 * ServiceProvider
 *
 * @package Laradic\Support${NAME}
 */
class SupportServiceProvider extends ServiceProvider
{

    /** @inheritdoc */
    protected $configFiles = [];

    /** @inheritdoc */
    protected $dir = __DIR__;

    /** @inheritdoc */
    public function boot()
    {
        parent::boot();
    }

    /** @inheritdoc */
    public function register()
    {
        parent::register();
        AliasLoader::getInstance()->alias('Path', 'Laradic\Support\Path');
        $this->app->register('Laradic\Support\Providers\LoggerServiceProvider');
    }

}
