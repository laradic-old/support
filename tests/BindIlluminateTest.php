<?php namespace Radic\Tests\Support;

use Radic\Support\Traits\BindIlluminateTrait;
/**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package         Radic\Tests\Support
 * @author          Robin Radic
 * @license         MIT
 * @copyright   (c) 2011-2015, Robin Radic
 * @link            http://radic.mit-license.org
 */
class BindIlluminateTest extends TestCase
{
    use BindIlluminateTrait;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @param array|mixed
     * @return \Illuminate\Container\Container
     */
    public function setupCore($app = null)
    {
        return $this->bindIlluminateCore($app);
    }
}
