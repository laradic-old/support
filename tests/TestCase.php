<?php

namespace Radic\Tests\Support;

use Radic\Dev\AbstractTestCase;
/**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package     Radic\Tests\Support
 * @author      Robin Radic
 * @license     MIT
 * @copyright   (c) 2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 *
 */
class TestCase extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return 'Radic\Support\SupportServiceProvider';
    }
}
