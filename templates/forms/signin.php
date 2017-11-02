<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('signin')) ?>
<?= $form->token() ?>

<?= $form->label('Email:')->forId('email')
    ->email('email')->id('email')
    ->placeholder('myself@mybusiness.com')->required() ?>

<?= $form->label('Password:')->forId('password')
    ->password('password')->id('password')
    ->placeholder('Your Secure Password')->required() ?>

<?= $form->submit('Sign In')->name('signin') ?>
