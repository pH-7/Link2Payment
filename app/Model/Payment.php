<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Model;

use PH7App\Core\Database;

class Payment
{
    private const TABLE_NAME = 'payment';

    /**
     * @param mixed $hash
     *
     * @return bool|\stdClass
     */
    public static function getPaymentInfo($hash)
    {
        Database::query('SELECT * FROM user AS u INNER JOIN payment AS p USING(userId) WHERE u.hash = :hash LIMIT 1', ['hash' => $hash]);

        return Database::fetch();
    }

    public static function insert(array $binds): void
    {
        Database::query('INSERT INTO ' . self::TABLE_NAME . ' (userId, publishableKey, secretKey, businessName, itemName, currency, amount, isBitcoin) VALUES(:user_id, :publishable_key, :secret_key, :business_name, :item_name, :currency, :amount, :is_bitcoin)', $binds);
    }

    public static function update(array $binds): void
    {
        Database::query('UPDATE ' . self::TABLE_NAME . ' SET publishableKey = :publishableKey, secretKey = :secretKey, businessName = :businessName, itemName = :itemName, currency = :currency, amount = :amount WHERE userId = :user_id LIMIT 1', $binds);
    }
}
