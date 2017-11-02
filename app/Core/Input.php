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
    /**
     * Returns the IP address of the user.
     *
     * @return string The IP address.
     */
    public static function userIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Returns the agent of the user.
     *
     * @return string The user agent
     */
    public static function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
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
        return isset($_POST[$key]) ? $_POST[$key] : false;
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
        return isset($_GET[$key]) ? $_GET[$key] : false;
    }

    /**
     * Returns the value of a clean input.
     *
     * @param string $key
     *
     * @return string|bool
     */
    public static function clean($key)
    {
        return trim(addslashes(htmlentities($key)));
    }
}