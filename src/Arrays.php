<?php
/**
 * Arrays
 */
namespace Laradic\Support;

/**
 * Array helper functionality.
 * Combines all functionality from:
 * - Illuminate\Support\Arr
 * - Underscore\Types\Arrays
 *
 * {@inheritdoc}
 * @package        Laradic\Support
 * @author         Robin Radic
 * @license        MIT
 * @copyright  (c) 2011-2015, Robin Radic
 * @link           http://radic.mit-license.org
 *
 * @mixin \Underscore\Methods\ArraysMethods
 * @mixin \Illuminate\Support\Arr
 */
class Arrays
{

    public function __call($name, $arguments)
    {
        if ( method_exists('Illuminate\Support\Arr', $name) )
        {
            return forward_static_call_array([ 'Illuminate\Support\Arr', $name ], $arguments);
        }
        elseif ( method_exists('Underscore\Methods\ArraysMethods', $name) )
        {
            return forward_static_call_array([ 'Underscore\Types\Arrays', $name ], $arguments);
        }
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([ new static(), $name ], $arguments);
    }

    /**
     * unflatten
     *
     * @param array  $array
     * @param string $delimiter
     * @return array
     */
    public static function unflatten(array $array, $delimiter = '.')
    {
        $unflattenedArray = array();
        foreach ( $array as $key => $value )
        {
            $keyList  = explode($delimiter, $key);
            $firstKey = array_shift($keyList);
            if ( sizeof($keyList) > 0 )
            { //does it go deeper, or was that the last key?
                $subarray = static::unflatten(array( implode($delimiter, $keyList) => $value ), $delimiter);
                foreach ( $subarray as $subarrayKey => $subarrayValue )
                {
                    $unflattenedArray[ $firstKey ][ $subarrayKey ] = $subarrayValue;
                }
            }
            else
            {
                $unflattenedArray[ $firstKey ] = $value;
            }
        }

        return $unflattenedArray;
    }

    /**
     * Get a value from the array, and remove it.
     *
     * @param  array  $array
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function pull(&$array, $key, $default = null)
    {
        $value = static::get($array, $key, $default);

        static::forget($array, $key);

        return $value;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array  $array
     * @param  string $key
     * @param  mixed  $value
     * @return array
     */
    public static function set(&$array, $key, $value)
    {
        if ( is_null($key) )
        {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while ( count($keys) > 1 )
        {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if ( ! isset($array[ $key ]) || ! is_array($array[ $key ]) )
            {
                $array[ $key ] = [ ];
            }

            $array =& $array[ $key ];
        }

        $array[ array_shift($keys) ] = $value;

        return $array;
    }

    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param  array        $array
     * @param  array|string $keys
     * @return void
     */
    public static function forget(&$array, $keys)
    {
        $original =& $array;

        foreach ( (array)$keys as $key )
        {
            $parts = explode('.', $key);

            while ( count($parts) > 1 )
            {
                $part = array_shift($parts);

                if ( isset($array[ $part ]) && is_array($array[ $part ]) )
                {
                    $array =& $array[ $part ];
                }
            }

            unset($array[ array_shift($parts) ]);

            // clean up after each pass
            $array =& $original;
        }
    }
}
