<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7App\Core;

class User
{
    const HASH_LENGTH = 4; // When get more user, will need to increase it!

    public static function setAuth(int $userId, string $email): void
    {
        Session::set('userId', $userId);
        Session::set('email', $email);
    }

    public static function isLoggedIn(): bool
    {
        return (bool)(Session::get('userId') && Session::get('email'));
    }

    public static function getId(): int
    {
        return Session::get('userId');
    }

    public static function getEmail(): string
    {
        return Session::get('email');
    }

    /**
     * @return string Returns a unique ID string.
     */
    public static function generateHash(): string
    {
        $prefix = (string) mt_rand();

        return substr(md5(uniqid($prefix, true)), 0, static::HASH_LENGTH);
    }

    public static function getStripePaymentLink(string $hash): string
    {
        return site_url("s/$hash");
    }

    public static function getPaypalPaymentLink(string $hash): string
    {
        return site_url("p/$hash");
    }
}
