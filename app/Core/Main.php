<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

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