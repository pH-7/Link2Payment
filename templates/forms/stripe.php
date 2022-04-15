<?php namespace PH7App; ?>

<h3 class="center">
    <?= escape($item_name) ?> - <?= escape($business_name) ?>
</h3>

<div class="center">
    <?php $form = new \AdamWathan\Form\FormBuilder; ?>
    <?= $form->open()->action(site_url('stripe-checkout')) ?>
    <?= $form->hidden('hash')->value($hash) ?>

    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?= escape($publishable_key) ?>"
        data-name="<?= escape($business_name) ?>"
        data-description="<?= escape($item_name) ?>"
        data-amount="<?= escape($amount) ?>"
        data-currency="<?= escape($currency) ?>"
        data-allow-remember-me="true"
        <?php if ($is_bitcoin): ?>
            data-bitcoin="true"
        <?php endif ?>
    >
    </script>

    <?= $form->close() ?>
</div>
