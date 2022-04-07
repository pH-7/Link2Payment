<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

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
        Database::query('INSERT INTO ' . self::TABLE_NAME . ' (userId, publishableKey, secretKey, paypalEmail, businessName, itemName, currency, amount, paymentGateway) VALUES(:user_id, :publishable_key, :secret_key, :paypal_email, :business_name, :item_name, :currency, :amount, :payment_gateway)', $binds);
    }

    public static function update(array $binds): void
    {
        Database::query('UPDATE ' . self::TABLE_NAME . ' SET publishableKey = :publishable_key, secretKey = :secret_key, paypalEmail = :paypal_email, businessName = :business_name, itemName = :item_name, currency = :currency, amount = :amount, isBitcoin = :is_bitcoin, paymentGateway = :payment_gateway WHERE userId = :user_id LIMIT 1', $binds);
    }
}
