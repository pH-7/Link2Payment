<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Test\Core\Input;

use PH7App\Core\Input;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testPostWithHtmlEntities(): void
    {
        $_POST['hi'] = '<b>Hi All</b>';

        $this->assertSame('Hi All', Input::post('hi'));
    }

    public function testUnsetPostKey(): void
    {
        $this->assertFalse(Input::post('nothing'));
    }

    public function testGetWithHtmlEntities(): void
    {
        $_GET['hi'] = '<b>Hi All</b>';

        $this->assertSame('Hi All', Input::get('hi'));
    }

    public function testUnsetGetKey(): void
    {
        $this->assertFalse(Input::get('lalala'));
    }

    public function testInvalidIp(): void
    {
        $_SERVER['REMOTE_ADDR'] = '129292';

        // When it's an invalid IP, it returns "127.0.0.1" instead
        $this->assertSame('127.0.0.1', Input::userIp());
    }

    public function testValidRemoteAddrIp(): void
    {
        $_SERVER['REMOTE_ADDR'] = '108.170.3.142';

        // When it's a valid IP, it returns it
        $this->assertSame('108.170.3.142', Input::userIp());
    }

    public function testValidXForwardedForIp(): void
    {
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '208.181.244.194';

        // When it's a valid IP, it returns it
        $this->assertSame('208.181.244.194', Input::userIp());
    }

    public function testValidClientIp(): void
    {
        $_SERVER['HTTP_CLIENT_IP'] = '208.181.244.199';

        // When it's a valid IP, it returns it
        $this->assertSame('208.181.244.199', Input::userIp());
    }

    protected function tearDown(): void
    {
        unset($_POST, $_GET);
    }
}
