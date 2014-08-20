<?php

namespace Karma\Util;

class Search
{
    public static function search($className, $fields, $string)
    {
        $attrs = self::resolveSearchString($string);
        $result = $className::getModel();
        foreach ($fields as $field)
        {
            foreach ($attrs as $attr)
                $result = $result->orWhere($field, 'LIKE', $attr);
        }
        return $result;
    }
    
    private static function resolveSearchString($arg)
    {
        if (!is_array($arg))
            $arg = explode(' ', $arg);
        
        return $arg;
    }
}