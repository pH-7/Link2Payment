<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2018, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Controller;

use PH7App\Core\Input;
use PH7App\Core\View;
use PH7App\Model\Payment as PaymentModel;
use stdClass;
use Stripe\Charge;
use Stripe\Stripe;

class Payment extends Base
{
    public const STRIPE_GATEWAY = 'stripe';
    public const PAYPAL_GATEWAY = 'paypal';

    private const PAYPAL_PAYMENT_URL = 'https://www.paypal.com/cgi-bin/webscr';

    public function stripe(): void
    {
        $hash = Input::get('hash');
        $paymentDetails = PaymentModel::getPaymentInfo($hash);

        if ($this->isStripeSet($paymentDetails)) {
            $tplVars = [
                'payment_gateway' => $paymentDetails->paymentGateway,
                'business_name' => $paymentDetails->businessName,
                'publishable_key' => $paymentDetails->publishableKey,
                'item_name' => $paymentDetails->itemName,
                'amount' => $paymentDetails->amount,
                'currency' => $paymentDetails->currency,
                'is_bitcoin' => $paymentDetails->isBitcoin,
                'hash' => $paymentDetails->hash
            ];

            View::create('forms/stripe', $paymentDetails->businessName, $tplVars);
        } else {
            $this->notFoundPage();
        }
    }

    public function stripeCheckout(): void
    {
        $hash = Input::post('hash');
        $stripeToken = Input::post('stripeToken');
        $stripeEmail = Input::post('stripeEmail');
        $dbData = PaymentModel::getPaymentInfo($hash);

        Stripe::setApiKey($dbData->secretKey);

        try {
            $charge = Charge::create(
                [
                    'amount' => $this->getIntegerAmount($dbData->amount),
                    'currency' => $dbData->currency,
                    'source' => $stripeToken,
                    'description' => sprintf('Membership charged for %s',$stripeEmail)
                ]
            );

            $this->sendEmailToSeller(['name' => $dbData->fullname, 'email' => $dbData->email]);
            $this->sendEmailToBuyer(['email' => $stripeEmail]);

            View::create('payment-done', 'Payment Done', ['seller_email' => $dbData->email]);
        } catch (\Stripe\Error\Card $except) {
            // The card has been declined
            $this->errorPage($except->getMessage());
        } catch (\Stripe\Error\Base $except) {
            $this->errorPage($except->getMessage());
        }
    }

    public function paypal(): void
    {
        $hash = Input::get('hash');
        $paymentDetails = PaymentModel::getPaymentInfo($hash);

        if ($this->isPayPalSet($paymentDetails)) {
            $urlQueries = $this->getPaypalUrlQueries($paymentDetails);
            redirect(static::PAYPAL_PAYMENT_URL . '?' . $urlQueries);
        } else {
            $this->notFoundPage();
        }
    }

    /**
     * @param array $sellerDetails
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure.
     */
    private function sendEmailToSeller(array $sellerDetails): int
    {
        $email = $_ENV['ADMIN_EMAIL'];
        $textMessage = sprintf("Hi %s!\r\n\r\n Congrats! You receive a new payment, made with %s", $sellerDetails['name'], site_name());

        $transport = \Swift_MailTransport::newInstance();
        $mailer = \Swift_Mailer::newInstance($transport);

        // Create a message
        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom([$email => site_name()])
            ->setTo([$sellerDetails['email'] => $sellerDetails['name']])
            ->setBody($textMessage);

        return $mailer->send($message);
    }

    /**
     * @param array $buyerDetails
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure.
     */
    private function sendEmailToBuyer(array $buyerDetails): int
    {
        /**
         * TODO: Not implemented yet
         */

        return 0;
    }

    /**
     * @param string $sPrice Normal price format (e.g., 19.95).
     *
     * @return int Returns amount in cents (without points) to be validated for Stripe.
     */
    private function getIntegerAmount(string $sPrice): int
    {
        return (int)str_replace('.', '', $sPrice);
    }

    private function getPaypalUrlQueries(stdClass $paymentDetails): string
    {
        $queries = [
            'cmd' => '_xclick',
            'business' => $paymentDetails->paypalEmail,
            'item_name' => $paymentDetails->itemName,
            'amount' => $paymentDetails->amount,
            'currency_code' => $paymentDetails->currency
        ];

        return http_build_query($queries);
    }

    private function isStripeSet(stdClass $paymentDetails): bool
    {
        return !empty($paymentDetails) && $paymentDetails->paymentGateway === self::STRIPE_GATEWAY;
    }

    private function isPayPalSet(stdClass $paymentDetails): bool
    {
        return !empty($paymentDetails) && $paymentDetails->paymentGateway === self::PAYPAL_GATEWAY;
    }
}
