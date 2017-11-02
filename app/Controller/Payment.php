<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types = 1);

namespace PH7App\Controller;

use PH7App\Core\View;
use PH7App\Model\Payment;
use PH7App\Core\Input;

class Home extends Base
{
    public function stripe(): void
    {
        $hash = Input::get('id');
        $dbData = Payment::getPaymentInfo($hash);

        $tplVars = [
            'payment_gateway' => $dbData->paymentGateway,
            'businessName' => $dbData->business_name,
            'publishable_key' => $dbData->publishable_key,
            'item_name' => $dbData->itemName,
            'amount' => $dbData->amount,
            'currency' => $dbData->currency,
            'is_bitcoin' => $dbData->isBitcoin,
            'hash' => $dbData->hash
        ];

        View::create('forms/stripe', $dbData->businessName, $tplVars);
    }

    public function checkout(): void
    {
        $hash = Input::post('id');
        $dbData = Payment::getPaymentInfo($hash);

        \Stripe\Stripe::setApiKey($dbData->secretKey);

        try {
            $oCharge = \Stripe\Charge::create(
                [
                    'amount' => $this->getIntegerAmount($dbData->amount),
                    'currency' => $dbData->hash,
                    'source' => Input::post('stripeToken'),
                    'description' => sprintf('Membership charged for %s', Input::post('stripeEmail'))
                ]
            );

            $this->sendEmailToSeller();
            $this->sendEmailToBuyer();
        }
        catch (\Stripe\Error\Card $oE) {
            // The card has been declined
            // Do nothing here as "$this->bStatus" is by default FALSE and so it will display "Error occurred" msg later
        }
        catch (\Stripe\Error\Base $oE) {

        }

        View::create('forms/stripe', $dbData->businessName, $tplVars);
    }

    private function sendEmailToBuyer()
    {

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