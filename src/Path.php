<?php namespace Laradic\Support;

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
use Webmozart\PathUtil\Path as BasePath;

/**
 * Path
 *
 * @package Laradic\Support${NAME}
 */
class Path extends BasePath
{

    /**
     * Joins a split file system path.
     *
     * @param mixed $path Array or parameters of strings , The split path.
     *
     * @return string The joined path.
     */
    public static function join()
    {
        $args = func_get_args();
        if(func_num_args() === 1 and is_array($args[0]))
        {
            return join(DIRECTORY_SEPARATOR, $args[0]);
        }
        else
        {
            return join(DIRECTORY_SEPARATOR, $args);
        }

    }
}
