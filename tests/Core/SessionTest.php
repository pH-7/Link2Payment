<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Test\Core\Session;

use PH7App\Core\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }
    }

    public function testGetSession(): void
    {
        $cookieValue = 'I hate too many cookies';
        Session::set('iate', $cookieValue);

        $this->assertSame($cookieValue, Session::get('iate'));
    }

    public function testUnsetSession(): void
    {
        $this->assertFalse(Session::get('nothing'));
    }

    public function testShowCookie(): void
    {
        $cookieValue = 'I hate too many cookies';
        $_COOKIE['iate'] = $cookieValue;

        $this->assertSame($cookieValue, Session::showCookie('iate'));
    }

    protected function tearDown()
    {
        parent::tearDown();

        unset($_SESSION, $_COOKIE);
    }
}