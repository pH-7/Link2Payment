<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

namespace PH7App;

use PH7App\Core\Route;

Route::get('/', 'Home@index');
Route::getAndPost('/signup', 'Home@signup');
Route::getAndPost('/signin', 'Home@signin');
Route::getAndPost('/edit', 'Home@edit');
Route::post('/checkout', 'Payment@checkout');

// Redirection
Route::location('/apps', 'https://docs.google.com/document/d/1HU1dUSix37K1f6COKQkMcDLeE72RZK8Y1yP8EFO8L30/');
Route::location('/podcast', 'https://itunes.apple.com/us/podcast/tropical-mba-location-independent-entrepreneurship/id325757845');
