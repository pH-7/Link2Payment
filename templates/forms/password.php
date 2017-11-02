<?php namespace PH7App; ?>


<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('password')) ?>
<?= $form->token() ?>

<?= $form->label('Current Password:')->forId('current_password') ?>
<?= $form->password('current_password')->id('current_password')
    ->required() ?>

<?= $form->label('New Password:')->forId('new_password') ?>
<?= $form->password('new_password')->id('new_password')
    ->required() ?>

<?= $form->label('Repeat Password:')->forId('repeated_password') ?>
<?= $form->password('repeated_password')->id('repeated_password')
    ->required() ?>

<?= $form->button('Update Password')->type('submit')->name('update_password')->addClass('bold orange-text') ?>