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
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Radic\Support\Contracts\Logger;
/**
 * ChromeLogger
 *
 * @package Radic\Support\Logger\ChromeLogger
 */
abstract class AbstractLogger implements Logger
{
    protected $app;
    protected $factory;
    #protected $logger;
    public function __construct(Application $app)
    {
        $this->app = $app;
        #$this->logger = new \Monolog\Logger(Str::random(10));

    }
}
