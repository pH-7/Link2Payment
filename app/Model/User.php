<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7App\Model;

use PH7App\Core\Database;

class User
{
    private const TABLE_NAME = 'user';

    /**
     * @return bool|\stdClass
     */
    public static function getDetails(int $userId)
    {
        Database::query('SELECT * FROM user AS u INNER JOIN payment AS p USING(userId) WHERE u.userId = :user_id LIMIT 1', ['user_id' => $userId]);

        return Database::fetch();
    }

    public static function insert(array $binds): void
    {
        Database::query('INSERT INTO ' . self::TABLE_NAME . ' (email, password, hash, ip) VALUES(:email, :password, :hash, :ip)', $binds);
    }

    public static function update(array $binds): void
    {
        Database::query('UPDATE ' . self::TABLE_NAME . ' SET fullname = :fullname WHERE userId = :user_id LIMIT 1', $binds);
    }

    public static function getId(string $email): int
    {
        Database::query('SELECT userId FROM ' . self::TABLE_NAME . ' WHERE email = :email LIMIT 1', ['email' => $email]);

        return (int)Database::fetch()->userId ?? 0;
    }

    public static function doesAccountAlreadyExist(string $email): bool
    {
        Database::query('SELECT userId FROM ' . self::TABLE_NAME . ' WHERE email = :email LIMIT 1', ['email' => $email]);

        return Database::rowCount() > 0;
    }

    public static function getHashedPassword(string $email): string
    {
        Database::query('SELECT password FROM ' . self::TABLE_NAME . ' WHERE email = :email LIMIT 1', ['email' => $email]);

        return Database::fetch()->password ?? '';
    }

    public static function updatePassword(string $newPassword, int $userId): void
    {
        $binds = ['new_password' => $newPassword, 'user_id' => $userId];

        Database::query('UPDATE ' . self::TABLE_NAME . ' SET password = :new_password WHERE userId = :user_id LIMIT 1', $binds);
    }
}
