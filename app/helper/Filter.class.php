<?php
/**
 * Filter.class [ MODEL HELPER ]
 * Respnsável por disponibizar filtros!
 *
 * @author jaison
 * @copyright (c) 2016, Jaison J da Rosa
 */
class Filter {

    private static $allowedSpecial = '?@._-:,()/!+*=#; ';
    private static $allowedAlpha = '&abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private static $allowedNumeric = '0123456789';

    public static function toCommonText($value) {
        $allow = array_merge(str_split(self::$allowedAlpha), str_split(self::$allowedNumeric), str_split(self::$allowedSpecial));
        return self::filterString($value, $allow);
    }

    public static function toAlphaNumeric($value) {
        $allow = array_merge(str_split(self::$allowedAlpha), str_split(self::$allowedNumeric));
        return self::filterString($value, $allow);
    }

    public static function toNumeric($value) {
        $allow = str_split(self::$allowedNumeric);
        return self::filterString($value, $allow);
    }

    public static function cleanArray($variableList) {
        $result = array();
        foreach ($variableList as $key => $value) {
            $result[self::toAlphaNumeric($key)] = self::toCommonText($value);
        }
        return $result;
    }

    private static function filterString($value, $allow) {
        $filtered = htmlentities($value, ENT_COMPAT, "utf-8");

        $result = "";

        foreach (str_split($filtered) as $letra) {
            if (!in_array($letra, $allow))
                continue;
            $result .= $letra;
        }

        return strip_tags(addslashes(str_replace("\r", '', str_replace("\n", '', html_entity_decode($result, ENT_COMPAT, "utf-8")))));
    }

}