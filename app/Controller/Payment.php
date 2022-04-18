<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7App\Controller;

use PH7App\Core\Input;
use PH7App\Core\View;
use PH7App\Model\Payment as PaymentModel;
use stdClass;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\SendmailTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as EmailMessage;

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

            try {
                $this->sendEmailToSeller(['name' => $dbData->fullname, 'email' => $dbData->email]);
                $this->sendEmailToBuyer(['email' => $stripeEmail]);
            } catch (TransportExceptionInterface $error) {
                error_log('Error while sending email with Symfony Mailer. ' . $error->getMessage());
            }

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
     * @throws TransportExceptionInterface
     */
    private function sendEmailToSeller(array $sellerDetails): void
    {
        $email = $_ENV['ADMIN_EMAIL'];
        $textMessage = sprintf("Hi %s!\r\n\r\n Congrats! You receive a new payment, made with %s", $sellerDetails['name'], site_name());

        $transport = new SendmailTransport();
        $mailer = new Mailer($transport);

        $message = new EmailMessage();
        $message->from(new Address($email, site_name()));
        $message->to(new Address($email, site_name()));
        $message->subject('Payment Received');
        $message->priority(EmailMessage::PRIORITY_HIGHEST);
        $message->text($textMessage);

        $mailer->send($message);
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
