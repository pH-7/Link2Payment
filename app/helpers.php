<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7App {

}

namespace {
    function site_url(string $var = ''): string
    {
        $siteUrl = $_ENV['SITE_URL'];

        if (!empty($var)) {
            return $siteUrl . $var;
        }

        return $siteUrl;
    }

    function site_name(): string
    {
        return $_ENV['SITE_NAME'];
    }

    function asset_url(string $var): string
    {
        return $_ENV['SITE_URL'] . 'assets/' . $var;
    }

    function redirect(string $url, bool $permanent = true): void
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }

        if (strpos($url, 'http') === false) {
            $url = $_ENV['SITE_URL'] . $url;
        }

        header('Location: ' . $url);
        exit;
    }

    function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }
}
