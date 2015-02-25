<?php

namespace Radic\Support\Logger;
 /**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package     Radic\Support\Logger
 * @author      Robin Radic
 * @license     MIT
 * @copyright   (c) 2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
use Radic\Support\Contracts\Logger;
/**
 * ChromeLogger
 *
 * @package Radic\Support\Logger\ChromeLogger
 */
class NativeLogger extends AbstractLogger
{

    public function log()
    {
        call_user_func_array(['\ChromePhp', 'log'], func_get_args());
    }

    public function debug()
    {
        call_user_func_array(['\ChromePhp', 'debug'], func_get_args());
    }

    public function warn()
    {
        call_user_func_array(['\ChromePhp', 'warn'], func_get_args());
    }

    public function info()
    {
        call_user_func_array(['\ChromePhp', 'info'], func_get_args());
    }

    public function error()
    {
        call_user_func_array(['\ChromePhp', 'error'], func_get_args());
    }
}
