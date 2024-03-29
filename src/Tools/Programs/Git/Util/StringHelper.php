<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Integrations\Tools\Programs\Git\Util;

/**
 * Helper class to support language particularity.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class StringHelper
{
    private static $encoding = 'utf-8';

    public static function getEncoding()
    {
        return self::$encoding;
    }

    public static function setEncoding($encoding): void
    {
        self::$encoding = $encoding;
    }

    public static function strlen(string $string): int
    {
        return function_exists('mb_strlen') ? mb_strlen($string, self::$encoding) : strlen($string);
    }

    /**
     * @param int $start
     * @param false|int $length
     *
     * @return false|string
     */
    public static function substr(string $string, int $start, $length = false)
    {
        if (false === $length) {
            $length = self::strlen($string);
        }

        return function_exists('mb_substr') ? mb_substr($string, $start, $length, self::$encoding) : substr($string, $start, $length);
    }

    /**
     * @param string $needle
     *
     * @return false|int
     */
    public static function strpos(string $haystack, string $needle, int $offset = 0)
    {
        return function_exists('mb_strpos') ? mb_strpos($haystack, $needle, $offset, self::$encoding) : strpos($haystack, $needle, $offset);
    }

    /**
     * @param string $needle
     *
     * @return false|int
     */
    public static function strrpos(string $haystack, string $needle, $offset = 0)
    {
        return function_exists('mb_strrpos') ? mb_strrpos($haystack, $needle, $offset, self::$encoding) : strrpos($haystack, $needle, $offset);
    }
}
