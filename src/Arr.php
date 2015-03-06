<?php
/**
 * Arrays
 */
namespace Laradic\Support;

use Underscore\Types\Arrays;
/**
 * Arrays
 *
 * {@inheritdoc}
 * @package    Laradic\Support
 * @author     Robin Radic
 * @license    MIT
 * @copyright  (c) 2011-2015, Robin Radic
 * @link       http://radic.mit-license.org
 *
 */
class Arr extends Arrays
{

    public static function unflatten(array $array, $delimiter = '.') {
        $unflattenedArray = array();
        foreach ($array as $key => $value) {
            $keyList = explode($delimiter, $key);
            $firstKey = array_shift($keyList);
            if (sizeof($keyList) > 0) { //does it go deeper, or was that the last key?
                $subarray = static::unflatten(array(implode($delimiter, $keyList) => $value), $delimiter);
                foreach ($subarray as $subarrayKey => $subarrayValue) {
                    $unflattenedArray[$firstKey][$subarrayKey] = $subarrayValue;
                }
            } else {
                $unflattenedArray[$firstKey] = $value;
            }
        }
        return $unflattenedArray;
    }
}
