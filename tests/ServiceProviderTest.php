<?php
/**
 * Part of the Radic packges.
 * Licensed under the MIT license.
 *
 * @package        docs
 * @author         Robin Radic
 * @license        MIT
 * @copyright  (c) 2011-2015, Robin Radic
 * @link           http://radic.mit-license.org
 */

namespace Radic\Tests\Support;

use Radic\Dev\Traits\ServiceProviderTestCaseTrait;


/**
 * ServiceProviderTest
 *
 * @group support
 */
class ServiceProviderTest extends TestCase
{
    use ServiceProviderTestCaseTrait;

    /*
     *
     */
    public function testServiceProvider()
    {
        $this->runServiceProviderRegisterTest('Radic\Dev\DevServiceProvider');
        $this->runServiceProviderRegisterTest($this->getServiceProviderClass($this->app));
    }
}
