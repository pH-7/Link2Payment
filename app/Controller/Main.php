<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Controller;

use PH7App\Core\Input;
use PH7App\Core\Password;
use PH7App\Core\Session;
use PH7App\Core\User;
use PH7App\Core\View;
use PH7App\Model\Payment as PaymentModel;
use PH7App\Model\User as UserModel;

class Main extends Base
{
    public function index(): void
    {
        View::create('splash-homepage', 'Get your Stripe Payment Link to get paid everywhere');
    }

    public function home(): void
    {
        $userId = User::getId();
        $dbData = UserModel::getDetails($userId);
        $tplVars = ['fullname' => $dbData->fullname, 'payment_link' => User::getPaymentLink($dbData->hash)];

        View::create('home', 'Welcome!', $tplVars);
    }

    public function signup(): void
    {
        $data = [];

        if (!$this->isSpamBot() && Input::post('signup')) {
            $email = Input::post('email');

            if (!UserModel::doesAccountAlreadyExist($email)) {
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
                    'secret_key' => Input::post('secret_key'),
                    'business_name' => Input::post('business_name'),
                    'item_name' => Input::post('item_name'),
                    'currency' => Input::post('currency'),
                    'amount' => Input::post('amount')
                ];
                PaymentModel::insert($paymentData);

                User::setAuth($userId, $email);

                redirect('/');
            } else {
                $data = [View::ERROR_MSG_KEY => 'An account with this email address already exists. Please use another email address if you want to create another payment link.'];
            }
        }

        View::create('forms/signup', 'Sign In for Free!', $data);
    }

    public function signin(): void
    {
        $data = [];

        if (Input::post('signin')) {
            $email = Input::post('email');
            $password = Input::post('password');
            $dbPasswordHashed = UserModel::getPassword($email);

            if (Password::verify($password, $dbPasswordHashed)) {
                $userId = UserModel::getId($email);
                User::setAuth($userId, $email);

                $this->updatePasswordHashIfNeeded($password, $dbPasswordHashed, $userId);

                redirect('/');
            } else {
                $data = [View::ERROR_MSG_KEY => 'Wrong email/password.'];
            }
        }

        View::create('forms/signin', 'Sign In', $data);
    }

    public function edit(): void
    {
        $userId = User::getId();
        $tplVars = [];

        if (Input::post('edit')) {
            $userData = [
                'user_id' => $userId,
                'fullname' => Input::post('fullname')
            ];
            UserModel::update($userData);

            $paymentData = [
                'user_id' => $userId,
                'publishable_key' => Input::post('publishable_key'),
                'secret_key' => Input::post('secret_key'),
                'business_name' => Input::post('business_name'),
                'item_name' => Input::post('item_name'),
                'currency' => Input::post('currency'),
                'amount' => Input::post('amount'),
                'is_bitcoin' => (int)Input::post('is_bitcoin')
            ];
            PaymentModel::update($paymentData);

            $tplVars += [View::SUCCESS_MSG_KEY => 'Details successfully updated!'];
        }

        $dbData = UserModel::getDetails($userId);

        $tplVars += [
            'fullname' => $dbData->fullname,
            'publishable_key' => $dbData->publishableKey,
            'secret_key' => $dbData->secretKey,
            'business_name' => $dbData->businessName,
            'item_name' => $dbData->itemName,
            'currency' => $dbData->currency,
            'amount' => $dbData->amount,
            'is_bitcoin' => (bool)$dbData->isBitcoin
        ];

        View::create('forms/edit', 'Edit Your Details', $tplVars);
    }

    public function password(): void
    {
        $data = [];

        $email = User::getEmail();
        $currentPassword = Input::post('current_password');
        $password1 = Input::post('new_password');
        $password2 = Input::post('repeated_password');

        if (Input::post('update_password')) {
            $hashedPassword = UserModel::getPassword($email);
            if (Password::verify($currentPassword, $hashedPassword)) {
                if ($password1 === $password2) {
                    UserModel::updatePassword(Password::hash($password1), User::getId());

                    $data = [View::SUCCESS_MSG_KEY => 'Your password has been successfully changed.'];
                } else {
                    $data = [View::ERROR_MSG_KEY => "The passwords don't match."];
                }
            } else {
                $data = [View::ERROR_MSG_KEY => "Your current password isn't correct."];
            }
        }

        View::create('forms/password', 'Change Your Password', $data);
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

    public function updatePasswordHashIfNeeded(string $password, string $passwordHash, int $userId): void
    {
        if ($newPasswordHash = Password::needsRehash($password, $passwordHash)) {
            UserModel::updatePassword($newPasswordHash, $userId);
        }
    }
}