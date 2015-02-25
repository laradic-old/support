<?php namespace Laradic\Support\Traits;

trait MultiSingletonTrait {
    protected function __construct()
    {
        if(method_exists($this, 'init')){
            call_user_func_array([$this, 'init'], func_get_args());
        }
    }

    public static function instance($name = 'default')
    {
        if (isset(static::$instances[$name]))
        {
            return static::$instances[$name];
        }

        $instance = new static();

        static::$instances[$name] = $instance;

        return $instance;
    }

    private static $instances = array();

    abstract protected function init();
}
