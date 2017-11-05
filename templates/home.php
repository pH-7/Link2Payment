<?php namespace PH7App; ?>

<div class="center">
    <h3>Welcome
        <?php if (!empty($fullname)): ?>
            <span class="italic"><?= escape($fullname) ?></span>
        <?php endif ?>!
    </h3>

    <p>
        <label for="payment_link" class="bold">Your Stripe Payment Link (to share with anyone!):</label><br>
        <input class="center" type="text" name="payment_link" value="<?= $payment_link ?>" id="payment_link" readonly onclick="this.select()">
    </p>
</div>