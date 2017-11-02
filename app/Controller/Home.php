<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Controller;

use PH7App\Core\Input;
use PH7App\Core\View;
use PH7App\Core\Password;
use PH7App\Model\Payment as PaymentModel;
use PH7App\Model\User as UserModel;

class Home extends Base
{
    public function index(): void
    {
        View::create('homepage', 'Get your Stripe Payment Link to get paid everywhere');
    }

    public function signup(): void
    {
        if (Input::post('signup')) {
            $userData = [
                'email' => Input::post('email'),
                'password' => Password::hash(Input::post('password')),
            ];
            UserModel::insert($userData);

            $paymentData = [
                'publishable_key' => Input::post('publishable_key'),
                'private_key' => Input::post('private_key'),
                'business_name' => Input::post('business_name'),
                'item_name' => Input::post('item_name'),
                'currency' => Input::post('currency'),
                'amount' => Input::post('amount')
            ];
            PaymentModel::insert($paymentData);

        }
        View::create('forms/signup', 'Register');
    }

    public function signin(): void
    {

        if (Input::post('signin')) {
            $password = Password::Input::post('password');

            User::getPassword(Input::post('email'));
        }

        View::create('forms/signin', 'Sign In for Free!', $data);
    }

    public function edit(): void
    {

        View::create('forms/edit', 'Edit Your Details');
    }
}