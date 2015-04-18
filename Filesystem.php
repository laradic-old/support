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

use Illuminate\Filesystem\Filesystem as BaseFS;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * Class Filesystem
 *
 * @package     Support
 */
class Filesystem extends BaseFS
{

    /**
     * Recursive glob
     *
     * @param     $pattern
     * @param int $flags
     * @return array
     */
    public function rglob($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir)
        {
            $files = array_merge($files, $this->rglob($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }

    /**
     * Search the folder recursively for files using regular expressions
     *
     * @param $folder
     * @param $pattern
     * @return array
     */
    public function rsearch($folder, $pattern)
    {
        $dir      = new RecursiveDirectoryIterator($folder);
        $ite      = new RecursiveIteratorIterator($dir);
        $files    = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
        $fileList = array();
        foreach ($files as $file)
        {
            $fileList = array_merge($fileList, $file);
        }

        return $fileList;
    }
}
