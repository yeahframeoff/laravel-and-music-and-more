<?php

namespace Karma\Util;

class Search
{
    public static function searchDeezer($q)
    {
        $search = new \Karma\Util\Deezer($q, 'autocomplete');
        $result = $search->search();
        return $result;
    }

    public static function search($string, $className, $fields, array $related = array())
    {
        $attrs = self::resolveSearchString($string);
        $result = $className::getModel();
        $fields = self::resolveArrayParam($fields);

        foreach ($fields as $field)
            foreach ($attrs as $attr)
                $result = $result->orWhere($field, 'LIKE', '%' . $attr . '%');

        $withArray = array();
        foreach ($related as $relation => $relFields)
        {
            if (!is_array($relFields))
                $relFields = self::resolveArrayParam($relFields);
            $withArray[$relation] = function($query) use ($relFields, $attrs)
            {
                foreach ($relFields as $field)
                    foreach ($attrs as $attr)
                        $query->orWhere($field, 'LIKE', '%' . $attr . '%');
            };
        }
        if (!empty ($withArray))
            $result = $result->with($withArray);
        $result = $result->get();
        return $result;
    }

    private static function resolveArrayParam($param)
    {
        if (!is_array($param))
            $param = array($param);
        return $param;
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
