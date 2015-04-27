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
     * @param $styles
     * @param $text
     * @return string
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     * @internal param array|string $style
     */
    public function colorize($styles, $text)
    {
        return $this->style($styles, $text);
    }

    /**
     * @param mixed
     */
    public function dump()
    {
        VarDumper::dump(func_get_args());
    }


    /**
     * style
     *
     * @param $styles
     * @param $str
     * @return string
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    protected function style($styles, $str)
    {
        return $this->colors->apply($styles, $str);
    }

    /**
     * select
     *
     * @param       $question
     * @param array $choices
     * @param null  $default
     * @param null  $attempts
     * @param null  $multiple
     * @return int|string
     */
    public function select($question, array $choices, $default = null, $attempts = null, $multiple = null)
    {
        $question = $this->style([ 'bg_light_gray', 'dark_gray', 'bold' ], " $question ");
        if ( isset($default) )
        {
            $question .= $this->style(
                [ 'bg_dark_gray', 'light_gray' ],
                " [" . ($default === false ? 'y/N' : 'Y/n') . "] "
            );
        }

        $choice = $this->choice($question, $choices, $default, $attempts, $multiple);
        foreach ( $choices as $k => $v )
        {
            if ( $choice === $v )
            {
                return $k;
            }
        }
    }

    /**
     * arrayTable
     *
     * @param $arr
     */
    protected function arrayTable($arr)
    {

        $rows = [ ];
        foreach ( $arr as $key => $val )
        {
            if ( is_array($val) )
            {
                $val = print_r(array_slice($val, 0, 5), true);
            }
            $rows[ ] = [ (string)$key, (string)$val ];
        }
        $this->table([ 'Key', 'Value' ], $rows);
    }

    /**
     * confirm
     *
     * @param string $question
     * @param bool   $default
     * @return bool
     */
    public function confirm($question, $default = false)
    {
        $question = $this->style([ 'bg_light_gray', 'dark_gray', 'bold' ], " $question ");
        $question .= $this->style([ 'bg_dark_gray', 'light_gray' ], " [" . ($default === false ? 'y/N' : 'Y/n') . "] ");

        return parent::confirm($question, $default);
    }

    public function ask($question, $default = null)
    {
        $question = $this->style([ 'bg_light_gray', 'dark_gray', 'bold' ], " $question ");
        if ( isset($default) )
        {
            $question .= $this->style(['bg_dark_gray', 'light_gray'], " $default ");
        }

        return parent::ask($question, $default);
    }
}
