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
use PH7App\Model\Payment as PaymentModel;
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
        $dbData = PaymentModel::getPaymentInfo($hash);

        if (!empty($dbData) && $dbData->paymentGateway === self::STRIPE_GATEWAY) {
            $tplVars = [
                'payment_gateway' => $dbData->paymentGateway,
                'business_name' => $dbData->businessName,
                'publishable_key' => $dbData->publishableKey,
                'item_name' => $dbData->itemName,
                'amount' => $dbData->amount,
                'currency' => $dbData->currency,
                'is_bitcoin' => $dbData->isBitcoin,
                'hash' => $dbData->hash
            ];

            View::create('forms/stripe', $dbData->businessName, $tplVars);
        } else {
            $this->notFoundPage();
        }
    }

    public function stripeCheckout(): void
    {
        $hash = Input::post('hash');
        $dbData = PaymentModel::getPaymentInfo($hash);

        Stripe::setApiKey($dbData->secretKey);

        try {
            $oCharge = Charge::create(
                [
                    'amount' => $this->getIntegerAmount($dbData->amount),
                    'currency' => $dbData->hash,
                    'source' => Input::post('stripeToken'),
                    'description' => sprintf('Membership charged for %s', Input::post('stripeEmail'))
                ]
            );

            $this->sendEmailToSeller();
            $this->sendEmailToBuyer(['name' => $dbData->name, 'email' => $dbData->email]);

            View::create('payment-done', 'Payment Done', ['buyer_email' => $dbData->email]);
            return;
        }
        catch (\Stripe\Error\Card $oE) {
            // The card has been declined
            $this->errorPage($oE->getMessage());
        }
        catch (\Stripe\Error\Base $oE) {
            $this->errorPage($oE->getMessage());
        }
    }

    /**
     * @param array $buyerDetails
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure.
     */
    private function sendEmailToBuyer(array $buyerDetails): int
    {
        $email = getenv('ADMIN_EMAIL');
        $textMessage = sprintf("Hi %s!\r\n\r\n You receive a new payment made thanks %s", $buyerDetails['name'], site_name());

        $transport = \Swift_MailTransport::newInstance();
        $mailer = \Swift_Mailer::newInstance($transport);

        // Create a message
        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom([$email => site_name()])
            ->setTo([$buyerDetails['email'] => $buyerDetails['name']])
            ->setBody($textMessage);

        return $mailer->send($message);
    }

    public function paypal(): void
    {
        $hash = Input::get('hash');
        $dbData = PaymentModel::getPaymentInfo($hash);

        if (!empty($dbData) && $dbData->paymentGateway === self::PAYPAL_GATEWAY) {
            $queries = [
                'cmd' => '_xclick',
                'business' => $dbData->paypalEmail,
                'item_name' => $dbData->itemName,
                'amount' => $dbData->amount,
                'currency_code' => $dbData->currency
            ];
            $urlQueries = http_build_query($queries);

            redirect(static::PAYPAL_PAYMENT_URL . '?' . $urlQueries);
        } else {
            $this->notFoundPage();
        }
    }

    private function sendEmailToSeller()
    {

    }

    /**
     * @param string $sPrice Normal price format (e.g., 19.95).
     *
     * @return int Returns amount in cents (without points) to be validated for Stripe.
     */
    private function getIntegerAmount(string $sPrice)
    {
        return str_replace('.', '', $sPrice);
    }
}