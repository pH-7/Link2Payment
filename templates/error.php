<?php namespace PH7App; ?>

<section class="center">
    <h2>Error Occured!</h2>
    <p><strong>Oops! An error has occurred!</strong></p>
    <p><?= escape($message) ?></p>

    <p>
      Please try again later or <a href="mailto:<?= $_ENV['ADMIN_EMAIL'] ?>?subject=Error with Link2Payment">contact us</a> if the problem persists.
    </p>
</section>
