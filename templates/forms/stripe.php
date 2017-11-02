<?php namespace PH7App; ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('checkout')) ?>
<?= $form->hidden('hash')->value($hash) ?>
<script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo $publishable_key ?>"
    data-name="<?php echo $business_name ?>"
    data-description="<?php echo $item_name ?>"
    data-amount="<?php echo $amount ?>"
    data-currency="<?php echo $currency ?>"
    data-allow-remember-me="true"
    <?php if ($is_bitcoin) {
        echo 'data-bitcoin="true"';
    }
    ?>
>
</script>
</form>