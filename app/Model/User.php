<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Model;

use PH7App\Core\Database;

class User
{
    private const TABLE_NAME = 'user';

    public static function insert(array $binds): void
    {
        Database::query('INSERT INTO ' . self::TABLE_NAME . ' (email, password) VALUES(:email, :password)', $binds);
    }

        public static function getPassword(array $bind): void
        {
            Database::query('SELECT password FROM ' . self::TABLE_NAME . ' WHERE email = :email LIMIT 1', $binds);
        }
 }
