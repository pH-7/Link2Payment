<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

namespace PH7App;

use PH7App\Core\Database;
use PH7App\Core\Main;

define('APP_PATH', __DIR__ . DIRECTORY_SEPARATOR);

require 'vendor/autoload.php';
require 'config/environment.php';
require 'helpers.php';

$debug = function () {
    if ((bool)getenv('DEBUG_MODE')) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(0);
        ini_set('display_errors', 'Off');
    }
};
$debug();


spl_autoload_register(function (string $className) {
    $className = str_replace([__NAMESPACE__ . '\\', '\\'], '/', $className);

    $filename = APP_PATH . $className . '.php';
    if (is_readable($filename)) {
        require $filename;
    }
});


try {
    $dbDetails = [
        'dbHost' => getenv('DB_HOST'),
        'dbUser' => getenv('DB_USER'),
        'dbPass' => getenv('DB_PWD'),
        'dbName' => getenv('DB_NAME')
    ];
    Database::connect($dbDetails);

    require 'routes.php';
} catch (Exception $except) {
    echo $except->getMessage();
}



