<?php namespace PH7App; ?>

<?php include dirname(__DIR__, 1) . '/includes/message.inc.php' ?>

<div class="row">
  <?php $form = new \AdamWathan\Form\FormBuilder; ?>
  <?= $form->open()->addClass('col s12')->action(site_url('password')) ?>
  <?= $form->token() ?>
  <?= $form->hidden('update_password')->value(1) ?>

  <p>
      <?= $form->label('Current Password:')->forId('current_password') ?>
      <?= $form->password('current_password')->id('current_password')
          ->required() ?>
  </p>

  <p>
      <?= $form->label('New Password:')->forId('new_password') ?>
      <?= $form->password('new_password')->id('new_password')
          ->pattern('.{6,}')->title('Password must be at least 6 characters long')
          ->required() ?>
  </p>

  <p>
      <?= $form->label('Repeat Password:')->forId('repeated_password') ?>
      <?= $form->password('repeated_password')->id('repeated_password')
          ->pattern('.{6,}')->title('Password must be at least 6 characters long')
          ->required() ?>
  </p>

  <p>
      <?= $form->submit('Change Password')->addClass('bold waves-effect btn-large') ?>
  </p>

  <?= $form->close() ?>
</div>
