<?php namespace Laradic\Support\Traits;

trait SingletonTrait {
    protected function __construct()
    {
        if(method_exists($this, 'init')){
            call_user_func_array([$this, 'init'], func_get_args());
        }
    }

    public static function instance()
    {
        if (isset(static::$instance))
        {
            return static::$instance;
        }

        $instance = new static();

        static::$instance = $instance;

        return $instance;
    }

    private static $instance;

    abstract protected function init();
}
