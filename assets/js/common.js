/*!
 * Author:        Pierre-Henry Soria <hi@ph7.me>
 * Copyright:     (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * License:       GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 */

$(document).ready(function() {
    $('select#currency').on('change', function () {
        $('span#currency').text($('select').val());
    });

    $('input.payment_gateway').on('click', function () {
        if ($(this).val() == 'stripe') {
            showStripeFields()
        } else {
            showPaypalField()
        }
    });
});

function showStripeFields()
{
    $('#stripe-settings').show();
    $('#paypal-settings').hide();
    $('input#publishable_key').attr('required');
    $('input#secret_key').attr('required');
    $('input#paypal_email').removeAttr('required');
}

function showPaypalField()
{
    $('#stripe-settings').hide();
    $('#paypal-settings').show();
    $('input#publishable_key').removeAttr('required');
    $('input#secret_key').removeAttr('required');
    $('input#paypal_email').attr('required');
}