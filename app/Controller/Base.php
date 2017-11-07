<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Controller;

use PH7App\Core\View;

class Base
{
    public function __construct()
    {
    }

    public function notFoundPage(): void
    {
        header('HTTP/1.1 404 Not Found');

        View::create('not-found', 'Page Not Found');
        exit;
    }

    public function errorPage(string $message): void
    {
        View::create('error', 'Error Occurred', ['message' => $message]);
        exit;
    }
}