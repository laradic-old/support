<?php
/**
 * Part of the Radic packages.
 */
namespace Laradic\Support;

use Illuminate\Console\Command;

use Symfony\Component\VarDumper\VarDumper;

/**
 * Class AbstractConsoleCommand
 *
 * @package     Laradic\Support
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
class AbstractConsoleCommand extends Command
{

    /**
     * @var \Laradic\Support\ConsoleColor
     */
    protected $colors;

    /**
     * Instanciates the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->colors = new ConsoleColor();
    }

    /**
     * @param string|array $style
     * @param $text
     * @throws \Laradic\Support\Exceptions\InvalidStyleException
     */
    public function colorize($style, $text)
    {
        return $this->colors->apply($style, $text);
    }

    /**
     * @param mixed
     */
    public function dump()
    {
        VarDumper::dump(func_get_args());
    }
}
