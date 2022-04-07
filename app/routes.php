<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

namespace PH7App;

use PH7App\Core\Route;
use PH7App\Core\User;

if (!User::isLoggedIn()) {
    Route::get('/', 'Main@index');
} else {
    Route::getAndPost('/', 'Main@home'); // Only for logged in users
}

Route::getAndPost('/signup', 'Main@signUp');
Route::getAndPost('/signin', 'Main@signIn');
Route::get('/stripe', 'Payment@stripe');
Route::post('/stripe-checkout', 'Payment@stripeCheckout');
Route::get('/paypal', 'Payment@paypal');

if (User::isLoggedIn()) { // Only for logged in users
    Route::getAndPost('/edit', 'Main@edit');
    Route::getAndPost('/password', 'Main@password');
    Route::getAndPost('/signout', 'Main@signOut');
}
