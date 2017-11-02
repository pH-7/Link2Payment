<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Core;

class User
{
    public static function auth(string $hash): void
    {
        Database::query('SELECT * FROM user AS u INNER JOIN payment AS p USING(userId) WHERE u.hash = :hash LIMIT 1');

        return Database::fetch();
    }
}
