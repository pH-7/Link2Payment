<?php namespace PH7App; ?>

<h3 class="center">Get Your Stripe Payment Link for Free</h3>

<?php include 'message.inc.php' ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('signup')) ?>
<?= $form->token() ?>
<?= $form->hidden('signup')->value(1) ?>

<?= $form->hidden('firstname')->addClass('nofield') // Spambot prevention using a hidden field ?>

<p>
    <?= $form->label('Valid Email:')->forId('email') ?>
    <?= $form->email('email')->id('email')
        ->placeholder('myself@mybusiness.com')->required() ?>
</p>

<p>
    <?= $form->label('Password:')->forId('password') ?>
    <?= $form->password('password')->id('password')
        ->placeholder('Your Secure Password')
        ->pattern('.{6,}')->title('Password must be at least 6 characters long')->required() ?>
</p>

<p>
    <?= $form->label('Business Name:')->forId('business') ?>
    <?= $form->text('business_name')->id('business')
        ->placeholder('Business Name Or Your Name')->required() ?>
</p>

<p>
    <?= $form->label('Item Name:')->forId('item') ?>
    <?= $form->text('item_name')->id('item')
        ->placeholder('Donation, Item Name, etc.')->required() ?>
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
        ->id('currency') ?>
</p>

<p>
    <?= $form->label(sprintf('%s Amount:', '<span id="currency">USD</span>'))
        ->forId('amount') ?>
    <?= $form->number('amount')->step('0.01')->id('amount')
        ->placeholder('99.99')->required() ?>
</p>

<p>
    <?= $form->label('Payment Gateway:') ?>
    <?= $form->radio('payment_gateway', 'stripe')->id('payment_gateway')->check() ?> Stripe
    <?= $form->radio('payment_gateway', 'paypal')->id('payment_gateway') ?> PayPal
</p>

<div id="stripe-settings">
    <p class="italic small">Get your <a href="https://stripe.com/docs/dashboard#api-keys" target="_blank" rel="noopener noreferrer">publishable/secret API keys</a> from your Stripe Account.</p>
    <p>
        <?= $form->label('Your Stripe Publishable Key:')->forId('publishable_key') ?>
        <?= $form->text('publishable_key')->id('publishable_key')->placeholder('sk_live_************************')
            ->required() ?>
    </p>

    <p>
        <?= $form->label('Your Stripe Secret Key:')->forId('secret_key') ?>
        <?= $form->text('secret_key')->id('secret_key')->placeholder('pk_live_************************')
            ->required() ?>
    </p>
</div>

<div id="paypal-settings" class="hidden">
    <p>
        <?= $form->label('Your PayPal Email:')->forId('paypal_email') ?>
        <?= $form->email('paypal_email')->id('paypal_email') ?>
    </p>
</div>

<p>
    <?= $form->submit('Sign Up')->addClass('bold waves-effect btn-large') ?>
</p>
