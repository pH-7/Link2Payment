<?php namespace PH7App; ?>

<?php include 'message.inc.php' ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('signin')) ?>
<?= $form->token() ?>
<?= $form->hidden('signin')->value(1) ?>

<p>
    <?= $form->label('Email:')->forId('email') ?>
    <?= $form->email('email')->id('email')
        ->placeholder('myself@mybusiness.com')->required() ?>
</p>

<p>
    <?= $form->label('Password:')->forId('password') ?>
    <?= $form->password('password')->id('password')
        ->placeholder('Your Secure Password')->required() ?>
</p>

<p>
    <?= $form->submit('Sign In')->addClass('bold waves-effect btn-large') ?>
</p>

<?= $form->close() ?>
