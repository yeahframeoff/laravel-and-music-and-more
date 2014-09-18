<?php

namespace Karma\Wrappers;


abstract class AbstractWrapper
{
    private static $insta;

    private static function instance()
    {
        if (self::$insta === null)
            self::$insta = new static;
        return self::$insta;
    }

    public static function wrap($model)
    {
        return static::instance()->wrap_single($model);
    }

    public static function wrapMany($model)
    {
        return static::instance()->wrapMany_single($model);
    }

    public static function template()
    {
        return static::instance()->template_single();
    }

    abstract public function wrap_single($model);

    abstract public function template_single();

    public function wrapMany_single($models)
    {
        $callable = function($m) {return $this->wrap_single($m);};
        if ( is_array($models))
            return array_map($callable, $models);
        else
            return $models->map($callable);
    }
} 