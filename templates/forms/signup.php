<?php namespace PH7App; ?>

<?php include 'message.inc.php' ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('signup')) ?>
<?= $form->token() ?>
<?= $form->hidden('signup')->value(1) ?>

<?= $form->hidden('firstname')->addClass('nofield') // Spambot prevention using a hidden field ?>

<?= $form->label('Email:')->forId('email') ?>
<?= $form->email('email')->id('email')
    ->placeholder('myself@mybusiness.com')->required() ?>

<?= $form->label('Password:')->forId('password') ?>
<?= $form->password('password')->id('password')
    ->placeholder('Your Secure Password')
    ->pattern('.{6,}')->title('Password must be at least 6 characters long')->required() ?>

<?= $form->label('Business Name:')->forId('business') ?>
<?= $form->text('business_name')->id('business')
    ->placeholder('Business Name Or Your Name')->required() ?>

<?= $form->label('Item Name:')->forId('item') ?>
<?= $form->text('item_name')->id('item')
    ->placeholder('Donation, Item Name, etc.')->required() ?>

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

<?= $form->label('Amount:')->forId('amount') ?>
<?= $form->number('amount')->step('0.01')->id('amount')
    ->placeholder('99.99')->required() ?>

<?= $form->label('Your Stripe Publishable Key:')->forId('publishable_key') ?>
<?= $form->text('publishable_key')->id('publishable_key')
    ->required() ?>

<?= $form->label('Your Stripe Secret Key:')->forId('secret_key') ?>
<?= $form->text('secret_key')->id('secret_key')
    ->required() ?>

<?= $form->submit('Sign Up')->addClass('bold waves-effect btn-large') ?>