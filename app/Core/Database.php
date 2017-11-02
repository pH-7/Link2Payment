<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Core;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    /** @var null|PDO */
    private static $_pdo = null;

    /** @var null|PDOStatement */
    private static $_stmt = null;

    /**
     * Establishes a connection.
     *
     * @param array $dbDetails The database details
     *
     * @return void
     */
    public static function connect(array $dbDetails = array())
    {
        try {
            static::$_pdo = new PDO('mysql:host=' . $dbDetails['dbHost'] . ';dbname=' . $dbDetails['dbName'], $dbDetails['dbUser'], $dbDetails['dbPass']);
            static::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            exit('<h1>An unexpected database error occured.</h1>');
        }
    }

    /**
     * Prepares a query and executes if applicable.
     *
     * @param string $sql The SQL to prepare
     * @param array $binds Values to bind to the query
     * @param bool $execute Automatically execute?
     *
     * @return void
     */
    public static function query($sql, array $binds = array(), bool $execute = true): void
    {
        static::$_stmt = static::$_pdo->prepare($sql);

        foreach ($binds as $key => $value) {
            static::$_stmt->bindValue($key, $value);
        }

        if ($execute === true) {
            static::$_stmt->execute();
        }
    }

    /**
     * Returns the number of affected rows from the last executed query.
     *
     * @return int The number of affected rows
     */
    public static function rowCount(): int
    {
        return static::$_stmt->rowCount();
    }

    /**
     * Returns a single row.
     *
     * @return stdClass The row as an object.
     */
    public static function fetch()
    {
        return static::$_stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @return string
     */
    public static function quote(string $string): string
    {
        return static::$_pdo->quote($string);
    }

    /**
     * Returns all rows
     *
     * @return stdClass The rows as an object.
     */
    public static function fetchAll()
    {
        return static::$_stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
