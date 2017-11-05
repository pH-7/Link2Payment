<?php namespace PH7App; ?>

<?php include 'message.inc.php' ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('signup')) ?>
<?= $form->token() ?>
<?= $form->hidden('signup')->value(1) ?>

<?= $form->hidden('firstname')->addClass('nofield') // Spambot prevention using a hidden field ?>

<p>
    <?= $form->label('Email:')->forId('email') ?>
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
    <?= $form->label('Amount:')->forId('amount') ?>
    <?= $form->number('amount')->step('0.01')->id('amount')
        ->placeholder('99.99')->required() ?>
</p>

<p class="italic small">Get your <a href="https://stripe.com/docs/dashboard#api-keys" target="_blank" rel="noopener noreferrer">publishable/secret API keys</a> from your Stripe Account.</p>
<p>
    <?= $form->label('Your Stripe Publishable Key:')->forId('publishable_key') ?>
    <?= $form->text('publishable_key')->id('publishable_key')
        ->required() ?>
</p>

<p>
    <?= $form->label('Your Stripe Secret Key:')->forId('secret_key') ?>
    <?= $form->text('secret_key')->id('secret_key')
        ->required() ?>
</p>

<p>
    <?= $form->submit('Sign Up')->addClass('bold waves-effect btn-large') ?>
</p>
