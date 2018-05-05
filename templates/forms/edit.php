<?php namespace PH7App; ?>

<?php include 'message.inc.php' ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('edit')) ?>
<?= $form->token() ?>
<?= $form->hidden('edit')->value(1) ?>

<p>
    <?= $form->label('Your Full Name:')->forId('fullname') ?>
    <?= $form->text('fullname')->value($fullname)->id('fullname')->required() ?>
</p>

<p>
    <?= $form->label('Business Name:')->forId('business') ?>
    <?= $form->text('business_name')->value($business_name)->id('business')
        ->required() ?>
</p>

<p>
    <?= $form->label('Item Name:')->forId('item') ?>
    <?= $form->text('item_name')->value($item_name)->id('item')
    ->required() ?>
</p>

<p>
    <?= $form->label('Currency:')->forId('currency') ?>
    <?php $currencies = [
        'USD' => 'USD',
        'CAD' => 'CAD',
        'EUR' => 'EUR',
        'GBP' => 'GBP',
        'AUD' => 'AUD',
        'HKD' => 'HKD',
        'SGD' => 'SGD',
        'JPY' => 'JPY',
        'NZD' => 'NZD'
    ] ?>
    <?= $form->select('currency', $currencies)
        ->id('currency')->select($currency) ?>
</p>

<p>
    <?= $form->label(sprintf('%s Amount:', '<span id="currency">' . $currency . '</span>'))
        ->forId('amount') ?>
    <?= $form->number('amount')->step('0.01')->value($amount)->id('amount')
        ->required() ?>
</p>

<p>
    <?= $form->label('Payment Gateway:') ?><br>

    <?php if ($payment_gateway === Controller\Payment::STRIPE_GATEWAY): ?>
        <?= $form->radio('payment_gateway', 'stripe')->class('payment_gateway')->id('stripe')->check() ?> <?= $form->label('Stripe')->forId('stripe') ?>
    <?php else: ?>
        <?= $form->radio('payment_gateway', 'stripe')->class('payment_gateway')->id('stripe') ?> <?= $form->label('Stripe')->forId('stripe') ?>
    <?php endif ?>

    <?php if ($payment_gateway === Controller\Payment::PAYPAL_GATEWAY): ?>
        <?= $form->radio('payment_gateway', 'paypal')->class('payment_gateway')->id('paypal')->check() ?> <?= $form->label('PayPal')->forId('paypal') ?>
    <?php else: ?>
        <?= $form->radio('payment_gateway', 'paypal')->class('payment_gateway')->id('paypal') ?> <?= $form->label('PayPal')->forId('paypal') ?>
    <?php endif ?>
</p>

<div id="stripe-settings" <?php if ($payment_gateway !== Controller\Payment::STRIPE_GATEWAY): ?>class="hidden"<?php endif ?>>
    <p class="italic small">
        Get your <a href="https://stripe.com/docs/dashboard#api-keys" target="_blank" rel="noopener noreferrer">publishable/secret API keys</a> from your Stripe Account.
    </p>

    <p>
        <?= $form->label('Stripe Publishable Key:')->forId('publishable_key') ?>
        <?= $form->text('publishable_key')->value($publishable_key)->id('publishable_key') ?>
    </p>

    <p>
        <?= $form->label('Stripe Secret Key:')->forId('secret_key') ?>
        <?= $form->text('secret_key')->value($secret_key)->id('secret_key') ?>
    </p>

    <p>
        <?= $form->label('Allow Bitcoin Payment?') ?><br>

        <?php if ($is_bitcoin): ?>
            <?= $form->radio('is_bitcoin', 0)->id('no_bitcoin') ?> <?= $form->label('No')->forId('no_bitcoin') ?>
        <?php else: ?>
            <?= $form->radio('is_bitcoin', 0)->id('no_bitcoin')->check() ?> <?= $form->label('No')->forId('no_bitcoin') ?>
        <?php endif ?>

        <?php if ($is_bitcoin): ?>
            <?= $form->radio('is_bitcoin', 1)->id('yes_bitcoin')->check() ?> <?= $form->label('Yes')->forId('yes_bitcoin') ?>
        <?php else: ?>
            <?= $form->radio('is_bitcoin', 1)->id('yes_bitcoin') ?> <?= $form->label('Yes')->forId('yes_bitcoin') ?>
        <?php endif ?>
    </p>
</div>

<div id="paypal-settings" <?php if ($payment_gateway !== Controller\Payment::PAYPAL_GATEWAY): ?>class="hidden"<?php endif ?>>
    <p>
        <?= $form->label('Your PayPal Email:')->forId('paypal_email') ?>
        <?= $form->email('paypal_email')->id('paypal_email')->value($paypal_email) ?>
    </p>
</div>

<p>
    <?= $form->submit('Update')->addClass('bold waves-effect btn-large') ?>
</p>

<?= $form->close() ?>
