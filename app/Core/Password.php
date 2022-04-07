<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7App\Core;

final class Password
{
    private const PWD_ALGORITHM = PASSWORD_BCRYPT;
    private const PWD_WORK_FACTOR = 12;

    private static $options = ['cost' => self::PWD_WORK_FACTOR];

    /**
     * Private constructor to prevent instantiation of class since it's a static class.
     */
    private function __construct()
    {
    }

    /**
     * Generate Random Salt for Password encryption.
     *
     * @param string|null $password
     *
     * @return string The Hash Password
     */
    public static function hash($password): string
    {
        return password_hash($password, self::PWD_ALGORITHM, self::$options);
    }

    /**
     * @param string|null $password
     * @param string|null $hash
     *
     * @return bool
     */
    public static function verify($password, $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Checks if the given hash matches the given options.
     *
     * @param string $password
     * @param string $hash
     *
     * @return string|bool Returns the new password if the password needs to be rehash, otherwise FALSE
     */
    public static function needsRehash(string $password, string $hash)
    {
        if (password_needs_rehash($hash, self::PWD_ALGORITHM, self::$options)) {
            return self::hash($password);
        }

        return false;
    }
}
