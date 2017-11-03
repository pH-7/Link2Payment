<?php namespace PH7App; ?>

<?php include 'message.inc.php' ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('edit')) ?>
<?= $form->token() ?>
<?= $form->hidden('edit')->value(1) ?>

<?= $form->label('Your Full Name:')->forId('fullname') ?>
<?= $form->text('fullname')->id('fullname')->required() ?>

<?= $form->label('Business Name:')->forId('business') ?>
<?= $form->text('business_name')->id('business')
    ->placeholder('Business Name Or Your Name')->required() ?>

<?= $form->label('Item Name:')->forId('item') ?>
<?= $form->text('item_name')->id('currency')
    ->placeholder('Donation ...')->required() ?>

<?= $form->label('Currency:')->forId('currency') ?>
<?= $form->select('currency', ['USD', 'CAD', 'EUR', 'GBP', 'AUD', 'HKD', 'SGD', 'JPY', 'NZD'])
    ->id('currency') ?>

<?= $form->label('Stripe Publishable Key:')->forId('publishable_key') ?>
<?= $form->text('publishable_key')->id('publishable_key')
    ->required() ?>

<?= $form->label('Stripe Secret Key:')->forId('secret_key') ?>
<?= $form->text('publishable_key')->id('publishable_key')
    ->required() ?>

<?= $form->label('Business Name:')->forId('business') ?>
<?= $form->text('business_name')->id('business')
    ->placeholder('Business Name Or Your Name')->required() ?>

<?= $form->submit('Update')->addClass('bold waves-effect btn-large') ?>
