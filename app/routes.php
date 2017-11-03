<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

namespace PH7App;

use PH7App\Core\User;
use PH7App\Core\Route;

if (!User::isLoggedIn()) {
    Route::get('/', 'Main@index');
} else {
    Route::getAndPost('/', 'Main@home'); // Only for logged in users
}

Route::getAndPost('/signup', 'Main@signup');
Route::getAndPost('/signin', 'Main@signin');
Route::post('/stripe', 'Payment@stripe');
Route::post('/checkout', 'Payment@checkout');

if (User::isLoggedIn()) { // Only for logged in users
    Route::getAndPost('/edit', 'Main@edit');
    Route::getAndPost('/password', 'Main@password');
    Route::getAndPost('/signout', 'Main@signout');
}

// Redirection
Route::location('/apps', 'https://docs.google.com/document/d/1HU1dUSix37K1f6COKQkMcDLeE72RZK8Y1yP8EFO8L30/');
Route::location('/podcast', 'https://itunes.apple.com/us/podcast/tropical-mba-location-independent-entrepreneurship/id325757845');
