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

use Exception;
use Illuminate\Support\MessageBag;
use Laradic\Support\Contracts\Validable;

/**
 * Class AbstractService
 *
 * @package     Laradic\Support
 */
abstract class AbstractService
{

    /**
     * The errors MesssageBag instance
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * An array of Validable classes
     *
     * @param array
     */
    protected $validators;

    /**
     * Create a new instance of Illuminate\Support\MessageBag
     * automatically when the child class is created
     *
     * @param array $validators
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;
        $this->errors     = new MessageBag;
    }

    /**
     * Return the errors MessageBag
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }

}
