<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('edit')) ?>
<?= $form->token() ?>

<?= $form->label('Email:')->forId('email')
    ->email('email')->id('email')
    ->placeholder('myself@mybusiness.com')->required() ?>

<?= $form->label('Your Full Name:')->forId('fullname')
    ->text('fullname')->id('fullname')->required() ?>

<?= $form->label('Business Name:')->forId('business')
    ->text('business_name')->id('business')
    ->placeholder('Business Name Or Your Name')->required() ?>

<?= $form->label('Password:')->forId('password')
    ->password('password')->id('password')
    ->placeholder('Your Secure Password')->required() ?>

<?= $form->label('Item Name:')->forId('item')
    ->text('item_name')->id('currency')
    ->placeholder('Donation ...')->required() ?>

<?= $builder
    ->label('Currency:')->forId('currency')
    ->select('currency', ['USD', 'CAD', 'EUR', 'GBP', 'AUD', 'HKD', 'SGD', 'JPY', 'NZD'])
    ->id('currency') ?>

<?= $form->label('Stripe Publishable Key:')->forId('publishable_key')
    ->text('publishable_key')->id('publishable_key')
    ->required() ?>

<?= $form->label('Stripe Secret Key:')->forId('secret_key')
    ->text('publishable_key')->id('publishable_key')
    ->required() ?>

<?= $form->label('Business Name:')->forId('business')
    ->text('business_name')->id('business')
    ->placeholder('Business Name Or Your Name')->required() ?>

<?= $form->submit('Update')->name('Edit') ?>
