<?php

declare(strict_types = 1);

namespace PH7App\Core;

class Main
{
    /** @var array */
    private static $config = array();

    public static function isLoggedIn(): bool
    {
        return (bool)Session::showCookie('loggedIn');
    }

    /**
     * Returns a config value.
     *
     * @param string $key The key
     * @param string $secondKey Optional second key
     *
     * @return string|bool The value
     */
    public static function get(string $key, string $secondKey = '')
    {
        if (empty($secondKey)) {
            return isset(static::$config[$key]) ? static::$config[$key] : false;
        }

        return isset(static::$config[$key][$secondKey]) ? static::$config[$key][$secondKey] : false;
    }
}