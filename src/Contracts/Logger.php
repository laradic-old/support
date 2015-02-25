<?php namespace Radic\Support\Contracts;

/**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package         Radic\Support\Contracts
 * @author          Robin Radic
 * @license         MIT
 * @copyright   (c) 2011-2015, Robin Radic
 * @link            http://radic.mit-license.org
 */

interface Logger
{
    /** @return Logger */
    public function log();

    /** @return Logger */
    public function debug();

    /** @return Logger */
    public function warn();

    /** @return Logger */
    public function info();

    /** @return Logger */
    public function error();
}
