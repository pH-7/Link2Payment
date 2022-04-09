<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria.
 * @license        GNU General Public License
 */

namespace PH7App;

use Dotenv\Dotenv;

Dotenv::createImmutable(dirname(__DIR__, 2))->load();
