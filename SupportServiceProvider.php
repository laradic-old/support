<?php
/**
 * Part of the Laradic packages.
 * MIT License and copyright information bundled with this package in the LICENSE file.
 *
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
namespace Laradic\Support;

/**
 * Class SupportServiceProvider
 *
 * @package     Support
 */
class SupportServiceProvider extends ServiceProvider
{

    public function boot()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::boot();
    }

    public function register()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app          = parent::register();
        $app['files'] = $app->share(function () #Application $app)
        {
            return new Filesystem();
        });
        require_once __DIR__ . '/helpers.php';
    }
}
