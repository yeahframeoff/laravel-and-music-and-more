<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 21.08.14
 * Time: 0:26
 */

namespace Karma\Util;


class SearchTransliterateProvider
{
    private static $alphabets = null;

    public static function getAlphabets()
    {
        if (self::$alphabets === null)
            self::$alphabets = array_merge(
                self::makePossibleAlphabets(self::$enCyrAlphabet),
                self::makePossibleAlphabets(self::$cyrEnAlphabet),
                [ self::$qwertyEnCyr, array_flip(self::$qwertyEnCyr) ]
            );
        return self::$alphabets;
    }

    public static function transformByAlphabets($str, array $alphabets)
    {
        $res = array();
        foreach ($alphabets as $alpha)
            $res[] = strtr($str, $alpha);
        return $res;
    }

    private static function makePossibleAlphabets(array $arr)
    {
        $plain = array();
        $arrs = array();
        foreach ($arr as $letter => $variant)
            if (is_array($variant))
                $arrs[$letter] = $variant;
            else
                $plain[$letter] = $variant;

        //var_dump($arrs);
        //dd($arrs);

        $result = array('');
        foreach ($arrs as $letter => $letterVariants)
        {
            $copy = $result;
            $result = [];
            foreach ($copy as $alphabetVariant)
            {
                foreach ($letterVariants as $letterVariant)
                    $result[] = array_add($alphabetVariant, $letter, $letterVariant);
            }
        }

        foreach ($result as $i => $alphabetVariant)
            $result[$i] = array_merge($alphabetVariant, $plain);

        return $result;
    }

    private static $enCyrAlphabet = [
        'a' => 'а',        'b' => 'б',        'c' => ['с', 'ц'],
        'd' => 'д',        'e' => ['е', 'ё'], 'f' => 'ф',
        'g' => ['г', 'ж'], 'h' => ['х', 'г'], 'i' => 'и',
        'j' => ['ж', 'й'], 'k' => 'к',        'l' => 'л',
        'm' => 'м',        'n' => 'н',        'o' => 'о',
        'p' => 'п',        'q' => 'к',        'r' => 'р',
        's' => 'с',        't' => 'т',        'u' => ['у', 'ю'],
        'v' => 'в',        'w' => ['в', 'у'], 'x' => 'кс',
        'y' => ['й', 'ы'], 'z' => 'з',
    ];

    private static $cyrEnAlphabet = [
        'а' => 'a',        'б' => 'b',        'в' => 'v',
        'г' => 'g',        'д' => 'd',        'е' => 'e',
        'ё' => 'yo',       'ж' => ['j', 'g'], 'з' => 'z',
        'и' => 'i',        'й' => 'i',        'к' => 'k',
        'л' => 'l',        'м' => 'm',        'н' => 'n',
        'о' => 'o',        'п' => 'p',        'р' => 'r',
        'с' => 's',        'т' => 't',        'у' => 'y',
        'ф' => 'f',        'х' => 'h',        'ц' => 'c',
        'ч' => 'ch',       'ш' => 'sh',       'щ' => 'sch',
        'ы' => ['i', 'y'], 'э' => 'e',        'ю' => 'u',
        'я' => 'ya',
    ];

    private static $qwertyEnCyr = [
        'q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н',
        'u' => 'г', 'i' => 'ш', 'o' => 'щ', 'p' => 'з', '[' => 'х', ']' => 'ъ',
        'a' => 'ф', 's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п', 'h' => 'р',
        'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж', '\''=> 'э', 'z' => 'я',
        'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь',
        ',' => 'б', '.' => 'ю', '`' => 'ё',
    ];
} 