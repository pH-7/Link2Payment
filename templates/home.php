<?php namespace PH7App; ?>

<p>Welcome <span class="italic"><?= $fullname ?></span>!</p>

<p>
    <label for="payment_link" class="bold">Your Stripe Payment Link (to share with anyone!):</label><br>
    <input type="text" name="payment_link" value="<?= $payment_link ?>" id="payment_link" readonly onclick="this.select()">
</p>