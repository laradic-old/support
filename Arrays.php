<?php
/**
 * Arrays
 */
namespace Laradic\Support;

use Underscore\Types\Arrays as BaseArrays;

/**
 * Array helper functionality.
 * Combines all functionality from:
 * - Illuminate\Support\Arr
 * - Underscore\Types\Arrays
 *
 * {@inheritdoc}
 * @package    Laradic\Support
 * @author     Robin Radic
 * @license    MIT
 * @copyright  (c) 2011-2015, Robin Radic
 * @link       http://radic.mit-license.org
 *
 */
class Arrays
{

    public function __call($name, $arguments)
    {
        if ( method_exists('Illuminate\Support\Arr', $name) )
        {
            return forward_static_call_array([ 'Underscore\Types\Arrays', $name ], $arguments);
        }
        elseif ( method_exists('Underscore\Methods\ArrayMethods', $name) )
        {
            return forward_static_call_array([ 'Underscore\Types\Arrays', $name ], $arguments);
        }
    }

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
