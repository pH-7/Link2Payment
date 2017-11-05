<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Core;

class Input
{
    const REGEX_IP_FORMAT = '/^[a-z0-9:.]{7,}$/';
    const DEFAULT_IP = '127.0.0.1';

    /**
     * Returns the IP address of the user.
     *
     * @return string The IP address.
     */
    public static function userIp()
    {
        $ip = $_SERVER['REMOTE_ADDR']; // Default value

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return preg_match(static::REGEX_IP_FORMAT, $ip) ? $ip : static::DEFAULT_IP;
    }

    /**
     * Returns the agent of the user.
     *
     * @return string The user agent
     */
    public static function userAgent()
    {
        return static::clean($_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Returns the value of a POST variable.
     *
     * @param string $key
     *
     * @return string|bool
     */
    public static function post($key)
    {
        return isset($_POST[$key]) ? static::clean($_POST[$key]) : false;
    }

    /**
     * Returns the value of a GET variable.
     *
     * @param string $key
     *
     * @return string|bool
     */
    public static function get($key)
    {
        return isset($_GET[$key]) ? static::clean($_GET[$key]) : false;
    }

    /**
     * Returns the value of a clean input.
     *
     * @param string $value
     *
     * @return string
     */
    private static function clean($value)
    {
        return strip_tags($value);
    }
}