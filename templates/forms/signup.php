<?php namespace PH7App; ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('signup')) ?>
<?= $form->token() ?>

<?= $form->hidden('firstname')->addClass('nofield') // Spambot prevention using a hidden field ?>

<?= $form->label('Email:')->forId('email') ?>
<?= $form->email('email')->id('email')
    ->placeholder('myself@mybusiness.com')->required() ?>

<?= $form->label('Business Name:')->forId('business') ?>
<?= $form->text('business_name')->id('business')
    ->placeholder('Business Name Or Your Name')->required() ?>

<?= $form->label('Password:')->forId('password') ?>
<?= $form->password('password')->id('password')
    ->placeholder('Your Secure Password')->required() ?>

<?= $form->label('Item Name:')->forId('item') ?>
<?= $form->text('item_name')->id('currency')
    ->placeholder('Donation ...')->required() ?>

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

<?= $form->label('Stripe Publishable Key:')->forId('publishable_key') ?>
<?= $form->text('publishable_key')->id('publishable_key')
    ->required() ?>

<?= $form->label('Stripe Secret Key:')->forId('secret_key') ?>
<?= $form->text('secret_key')->id('secret_key')
    ->required() ?>

<?= $form->label('Business Name:')->forId('business') ?>
<?= $form->text('business_name')->id('business')
    ->placeholder('Business Name Or Your Name')->required() ?>

<?= $form->button('Sign Up')->type('submit')->name('signup')->addClass('bold orange-text') ?>