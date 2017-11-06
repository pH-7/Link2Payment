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
        ->placeholder('Business Name Or Your Name')->required() ?>
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
        ->placeholder('99.99')->required() ?>
</p>

<p>
    <?= $form->label('Payment Gateway:') ?>

    <?php if ($payment_gateway === Controller\Payment::STRIPE_GATEWAY): ?>
        <?= $form->radio('payment_gateway', 'stripe')->check() ?> Stripe
    <?php else: ?>
        <?= $form->radio('payment_gateway', 'stripe') ?> Stripe
    <?php endif ?>

    <?php if ($payment_gateway === Controller\Payment::PAYPAL_GATEWAY): ?>
        <?= $form->radio('payment_gateway', 'paypal')->check() ?> PayPal
    <?php else: ?>
        <?= $form->radio('payment_gateway', 'paypal') ?> PayPal
    <?php endif ?>
</p>

<div id="stripe-settings" <?php if ($payment_gateway !== Controller\Payment::STRIPE_GATEWAY): ?>class="hidden"<?php endif ?>>
    <p>
        <?= $form->label('Stripe Publishable Key:')->forId('publishable_key') ?>
        <?= $form->text('publishable_key')->value($publishable_key)->id('publishable_key')
            ->required() ?>
    </p>

    <p>
        <?= $form->label('Stripe Secret Key:')->forId('secret_key') ?>
        <?= $form->text('secret_key')->value($secret_key)->id('secret_key')
            ->required() ?>
    </p>

    <p>
        <?= $form->label('Allow Bitcoin Payment?') ?>

        <?php if ($is_bitcoin): ?>
            <?= $form->radio('is_bitcoin', 0) ?> No
        <?php else: ?>
            <?= $form->radio('is_bitcoin', 0)->check() ?> No
        <?php endif ?>

        <?php if ($is_bitcoin): ?>
            <?= $form->radio('is_bitcoin', 1)->check() ?> Yes
        <?php else: ?>
            <?= $form->radio('is_bitcoin', 1) ?> Yes
        <?php endif ?>
    </p>
</div>

<div id="paypal-settings" <?php if ($payment_gateway !== Controller\Payment::PAYPAL_GATEWAY): ?>class="hidden"<?php endif ?>>
    <p>
        <?= $form->label('Your PayPal Email:')->forId('paypal_email') ?>
        <?= $form->text('paypal_email')->id('paypal_email')
            ->value($paypal_email)->required() ?>
    </p>
</div>

<p>
    <?= $form->submit('Update')->addClass('bold waves-effect btn-large') ?>
</p>