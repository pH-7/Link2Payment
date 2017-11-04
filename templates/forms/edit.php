<?php namespace PH7App; ?>

<?php include 'message.inc.php' ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('edit')) ?>
<?= $form->token() ?>
<?= $form->hidden('edit')->value(1) ?>

<?= $form->label('Your Full Name:')->forId('fullname') ?>
<?= $form->text('fullname')->value($fullname)->id('fullname')->required() ?>

<?= $form->label('Business Name:')->forId('business') ?>
<?= $form->text('business_name')->value($business_name)->id('business')
    ->placeholder('Business Name Or Your Name')->required() ?>

<?= $form->label('Item Name:')->forId('item') ?>
<?= $form->text('item_name')->value($item_name)->id('item')
    ->required() ?>

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
    ->value($currency)->id('currency') ?>

<?= $form->label('Amount:')->forId('amount') ?>
<?= $form->number('amount')->step('0.01')->value($amount)->id('amount')
    ->placeholder('99.99')->required() ?>

<?= $form->label('Stripe Publishable Key:')->forId('publishable_key') ?>
<?= $form->text('publishable_key')->value($publishable_key)->id('publishable_key')
    ->required() ?>

<?= $form->label('Stripe Secret Key:')->forId('secret_key') ?>
<?= $form->text('secret_key')->value($secret_key)->id('secret_key')
    ->required() ?>

<?= $form->label('Allow Bitcoin Payment?')->forId('is_bitcoin') ?>
<?= $form->radio('is_bitcoin', 'No')->value($is_bitcoin)->id('is_bitcoin') ?>
<?= $form->radio('is_bitcoin', 'Yes')->value($is_bitcoin)->id('is_bitcoin') ?>

<?= $form->submit('Update')->addClass('bold waves-effect btn-large') ?>
