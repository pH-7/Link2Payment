<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Controller;

use PH7App;
use PH7App\Core\Input;
use PH7App\Core\View;
use PH7App\Core\Session;
use PH7App\Core\User;
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
            $email = Input::post('email');

            $userData = [
                'hash' => User::generateHash(),
                'email' => $email,
                'password' => Password::hash(Input::post('password'))
            ];
            UserModel::insert($userData);

            $userId = UserModel::getId($email);

            $paymentData = [
                'user_id' => $userId,
                'publishable_key' => Input::post('publishable_key'),
                'private_key' => Input::post('private_key'),
                'business_name' => Input::post('business_name'),
                'item_name' => Input::post('item_name'),
                'currency' => Input::post('currency'),
                'amount' => Input::post('amount')
            ];
            PaymentModel::insert($paymentData);

            User::setAuth($userId, $email);

            redirect('edit');
        }

        View::create('forms/signup', 'Register');
    }

    public function signin(): void
    {
        if (!$this->isSpamBot() && Input::post('signin')) {
            $email = Input::post('email');
            $password = Input::post('password');
            $dbPasswordHashed = UserModel::getPassword($email);

            if (Password::check($password, $dbPasswordHashed)) {
                $userId = UserModel::getId($email);
                User::setAuth($userId, $email);
            }

            redirect('edit');
        }

        View::create('forms/signin', 'Sign In for Free!');
    }

    public function edit(): void
    {
        $userId = User::getId();

        if (Input::post('signup')) {
            $userData = [
                'user_id' => $userId,
                'fullname' => Input::post('fullname')
            ];
            UserModel::update($userData, $userId);

            $paymentData = [
                'user_id' => $userId,
                'publishable_key' => Input::post('publishable_key'),
                'secret_key' => Input::post('secret_key'),
                'fullname' => Input::post('fullname'),
                'business_name' => Input::post('business_name'),
                'item_name' => Input::post('item_name'),
                'currency' => Input::post('currency'),
                'amount' => Input::post('amount')
            ];
            PaymentModel::update($paymentData, $userId);

        }

        View::create('forms/edit', 'Edit Your Details');
    }

    public function password(): void
    {
        $email = User::getEmail();
        $currentPassword = Input::post('current_password');
        $password1 = Input::post('new_password');
        $password2 = Input::post('repeated_password');

        if (Input::post('update_password')) {
            if (Password::hash($currentPassword) === UserModel::getPassword($email)) {
                if ($password1 === $password2) {
                    UserModel::updatePassword($password1, User::getId());

                    redirect('edit');
                } else {
                    // TODO: Not same password
                }

            } else {
                // TODO: Wrong current password
            }
        }


        View::create('forms/password', 'Update Your Password');
    }

    public function signout(): void
    {
        Session::destroy();

        redirect('/');
    }

    /**
     * Make sure that a human fulfil the form (a bot would fulfil "firstname" field as well).
     *
     * @return bool
     */
    private function isSpamBot(): bool
    {
        return (bool)Input::post('firstname');
    }
}