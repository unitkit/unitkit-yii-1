<?php

/**
 * This class is a static class that provides a collection of helper methods
 *
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseTools
{

    /**
     * Return ip address
     *
     * @return string
     */
    public static function ip()
    {
        $ip = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * Calculate the sha512 hash of a string
     *
     * @param string $string the input string
     * @return string
     */
    public static function sha512($string)
    {
        return hash('sha512', $string);
    }

    /**
     * Calculate the sha256 hash of a string
     *
     * @param string $string the input string
     * @return string
     */
    public static function sha256($string)
    {
        return hash('sha256', $string);
    }

    /**
     * Return current date
     */
    public static function now()
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * Generate a password
     *
     * @param int $length number of characters
     * @return string
     */
    public static function password($length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXY0123456789-_^~€%')
    {
        $charsLen = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; ++ $i)
            $string .= $chars[rand() % $charsLen];
        return $string;
    }

    /**
     * Utf8 decode
     *
     * @param string $string
     * @return string
     */
    public static function utf8Decode($string)
    {
        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $string);
    }

    /**
     * Convert an array to an xml string
     *
     * @param array $array the array to be converted
     * @param string? $rootElement if specified will be taken as root element, otherwise defaults to <root>
     * @param SimpleXMLElement? if specified content will be appended, used for recursion
     * @return string XML version of $array
     */
    public static function arrayToXml($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml;
        if ($_xml === null) {
            $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
        }

        foreach ($array as $k => $v) {
            if (is_array($v)) {
                arrayToXml($v, $k, $_xml->addChild($k));
            } else {
                $_xml->addChild($k, $v);
            }
        }

        return $_xml->asXML();
    }
}