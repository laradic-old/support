<?php namespace Radic\Support\Facades;

/**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package    dev9
 * @author     Robin Radic
 * @license    MIT
 * @copyright  (c) 2011-2015, Robin Radic
 * @link       http://radic.mit-license.org
 */
use Illuminate\Support\Facades\Facade;
/**
 * Markdown
 *
 * @package Radic\BladeExtensions\Facades${NAME}
 */
class Logger extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'radic.logger';
    }
}
