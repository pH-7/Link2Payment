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
        $_POST['hi'] ='<b>Hi All</b>';

        $this->assertSame('Hi All', Input::post('hi'));
    }

    public function testUnsetPostKey(): void
    {
        $this->assertFalse(Input::post('nothing'));
    }

    public function testHtmlGetWithEntities(): void
    {
        $_GET['hi'] ='<b>Hi All</b>';

        $this->assertSame('Hi All', Input::get('hi'));
    }

    public function testUnsetGetKey(): void
    {
        $this->assertFalse(Input::get('lalala'));
    }

    protected function tearDown()
    {
        unset($_POST, $_GET);
    }
}