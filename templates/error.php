<?php namespace PH7App; ?>

<div class="createAcc">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel">
                    <h2>Error Occured!</h2>
                    <p><strong>Oops! An error has occurred!</strong></p>
                    <p><?= escape($message) ?></p>
                    <p>Please try again later or <a href="mailto:<?= getenv('ADMIN_EMAIL') ?>?subject=Error with Link2Payment">contact us</a> if the problem persists.</p>
                </div>
            </div>
        </div>
    </div>
</div>