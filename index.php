<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

namespace PH7App;

require 'app/Bootstrap.php';

$oApp = new Bootstrap;
$oApp->initializeDebuggingMode();
$oApp->initializePHPSession();
$oApp->setTimezoneIfNotSet();

ob_start();
$oApp->run(); // Let's go baby!
ob_end_flush();
