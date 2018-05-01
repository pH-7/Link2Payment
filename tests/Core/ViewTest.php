<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Test\Core;

use PH7App\Core\View;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ViewTest extends TestCase
{
    public function testNotFoundView(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Could not find view: "templates/randomfile.php"');

        View::create('randomfile', '', [], View::PARTIALS_ENABLED);
    }
}
