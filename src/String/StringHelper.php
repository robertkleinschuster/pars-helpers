<?php


namespace Pars\Helper\String;


class StringHelper
{
    /**
     * @param string $str
     * @param string $needle
     * @return bool
     */
    public static function startsWith(string $str, string $needle): bool
    {
        return strpos($str, $needle) === 0;
    }

    /**
     * @param string $str
     * @param array $needle_List
     * @return bool
     */
    public static function startsWithAny(string $str, array $needle_List): bool
    {
        foreach ($needle_List as $needle) {
            if (self::startsWith($str, $needle)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $str
     * @param string $needle
     * @return bool
     */
    public static function endsWith(string $str, string $needle): bool
    {
        return strpos($str, $needle, strlen($needle) - 1) === 0;
    }
}
