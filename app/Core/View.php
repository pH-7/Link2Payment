<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2018, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7App\Core;

use RuntimeException;

final class View
{
    public const ERROR_MSG_KEY = 'error_msg';
    public const SUCCESS_MSG_KEY = 'success_msg';

    public const PARTIALS_ENABLED = true;
    public const PARTIALS_DISABLED = false;

    /**
     * @param string $view
     * @param string $title
     * @param array $data
     * @param bool $paritals
     *
     * @throws RuntimeException
     */
    public static function create(string $view, string $title = '', array $data = array(), bool $paritals = self::PARTIALS_DISABLED): void
    {
        extract($data);

        if (!$paritals) {
            include 'templates/includes/header.php';
        }

        $viewFullPath = 'templates/' . $view . '.php';
        if (is_file($viewFullPath)) {
            include $viewFullPath;
        } else {
            $errorMessage = sprintf('Could not find view: "%s"', $viewFullPath);
            throw new RuntimeException($errorMessage);
        }

        if (!$paritals) {
            include 'templates/includes/footer.php';
        }
    }
}
