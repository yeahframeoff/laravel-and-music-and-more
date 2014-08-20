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
                $result = $result->orWhere($field, 'LIKE', '%'.$attr.'%');
        }
        $result = $result->get();
        return $result;
    }
    
    private static function resolveSearchString($arg)
    {
        if (!is_array($arg))
        {
            $arg = trim($arg);
            $arg = empty($arg) ? array() : explode(' ', $arg);
        }
        $res = array();

        if (!empty ($arg))
        {
            $alphabets = SearchTransliterateProvider::getAlphabets();
            foreach ($arg as $argo)
            {
                $res[] = $argo;
                $res = array_merge ($res,
                    SearchTransliterateProvider::transformByAlphabets($argo, $alphabets)
                );
            }
        }

        return array_unique($res);
    }


}
