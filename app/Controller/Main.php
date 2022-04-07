<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2018, Pierre-Henry Soria. All Rights Reserved.
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
        View::create(
            'splash-homepage',
            'Get your Stripe Payment Link to get paid everywhere',
        );
    }

    public function home(): void
    {
        $userId = User::getId();
        $userDetails = UserModel::getDetails($userId);
        $methodName = $this->getPaymentGatewayMethod($userDetails->paymentGateway);
        $tplVars = ['fullname' => $userDetails->fullname, 'payment_link' => User::$methodName($userDetails->hash)];

        View::create('home', 'Welcome!', $tplVars);
    }

    public function signIn(): void
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

    public function signUp(): void
    {
        $data = [];

        if (Input::post('signup') && !$this->isSpamBot()) {
            $email = Input::post('email');

            $paymentGateway = Input::post('payment_gateway');
            $publishableKey = Input::post('publishable_key');
            $secretKey = Input::post('secret_key');
            $paypalEmail = Input::post('paypal_email');

            if ($paymentGateway === Payment::STRIPE_GATEWAY &&
                (!$publishableKey || !$secretKey)
            ) {
                $data = [View::ERROR_MSG_KEY => 'Publishable/Secret Keys are mandatory'];
            } elseif ($paymentGateway === Payment::PAYPAL_GATEWAY && !$paypalEmail) {
                $data = [View::ERROR_MSG_KEY => 'PayPal Email is mandatory'];
            } elseif (!UserModel::doesAccountAlreadyExist($email)) {
                $userData = [
                    'email' => $email,
                    'password' => Password::hash(Input::post('password')),
                    'hash' => User::generateHash(),
                    'ip' => Input::userIp()
                ];
                UserModel::insert($userData);

                $userId = UserModel::getId($email);

                $paymentData = [
                    'user_id' => $userId,
                    'publishable_key' => $publishableKey,
                    'secret_key' => $secretKey,
                    'paypal_email' => $paypalEmail,
                    'business_name' => Input::post('business_name'),
                    'item_name' => Input::post('item_name'),
                    'currency' => Input::post('currency'),
                    'amount' => Input::post('amount'),
                    'payment_gateway' => $paymentGateway
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

    public function edit(): void
    {
        $userId = User::getId();
        $tplVars = [];

        if (Input::post('edit')) {
            $paymentGateway = Input::post('payment_gateway');
            $publishableKey = Input::post('publishable_key');
            $secretKey = Input::post('secret_key');
            $paypalEmail = Input::post('paypal_email');

            if ($paymentGateway === Payment::STRIPE_GATEWAY &&
                (!$publishableKey || !$secretKey)
            ) {
                $tplVars += [View::ERROR_MSG_KEY => 'Publishable/Secret Keys are mandatory'];
            } elseif ($paymentGateway === Payment::PAYPAL_GATEWAY && !$paypalEmail) {
                $tplVars += [View::ERROR_MSG_KEY => 'PayPal Email is mandatory'];
            } else {
                $userData = [
                    'user_id' => $userId,
                    'fullname' => Input::post('fullname')
                ];
                UserModel::update($userData);

                $paymentData = [
                    'user_id' => $userId,
                    'publishable_key' => $publishableKey,
                    'secret_key' => $secretKey,
                    'paypal_email' => $paypalEmail,
                    'business_name' => Input::post('business_name'),
                    'item_name' => Input::post('item_name'),
                    'currency' => Input::post('currency'),
                    'amount' => Input::post('amount'),
                    'is_bitcoin' => (int)Input::post('is_bitcoin'),
                    'payment_gateway' => $paymentGateway
                ];
                PaymentModel::update($paymentData);

                $tplVars += [View::SUCCESS_MSG_KEY => 'Successfully saved!'];
            }
        }

        // Get user data from DB to fulfill the form field values
        $sellerDetails = UserModel::getDetails($userId);

        $tplVars += [
            'fullname' => $sellerDetails->fullname,
            'publishable_key' => $sellerDetails->publishableKey,
            'secret_key' => $sellerDetails->secretKey,
            'paypal_email' => $sellerDetails->paypalEmail,
            'business_name' => $sellerDetails->businessName,
            'item_name' => $sellerDetails->itemName,
            'currency' => $sellerDetails->currency,
            'amount' => $sellerDetails->amount,
            'is_bitcoin' => (bool)$sellerDetails->isBitcoin,
            'payment_gateway' => $sellerDetails->paymentGateway
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

    public function signOut(): void
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

    private function updatePasswordHashIfNeeded(string $password, string $passwordHash, int $userId): void
    {
        if ($newPasswordHash = Password::needsRehash($password, $passwordHash)) {
            UserModel::updatePassword($newPasswordHash, $userId);
        }
    }

    private function getPaymentGatewayMethod(string $gatewayName): string
    {
        return $gatewayName === Payment::STRIPE_GATEWAY ? User::STRIPE_LINK_METHOD_NAME : User::PAYPAL_LINK_METHOD_NAME;
    }
}
