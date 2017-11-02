<?php namespace PH7App; ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('signin')) ?>
<?= $form->token() ?>

<?= $form->label('Email:')->forId('email') ?>
<?= $form->email('email')->id('email')
    ->placeholder('myself@mybusiness.com')->required() ?>

<?= $form->label('Password:')->forId('password') ?>
<?= $form->password('password')->id('password')
    ->placeholder('Your Secure Password')->required() ?>

<?= $form->button('Sign In')->type('submit')->name('signin')->addClass('bold orange-text') ?>
