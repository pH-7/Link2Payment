<?php namespace PH7App; ?>

<?php include 'message.inc.php' ?>

<?php $form = new \AdamWathan\Form\FormBuilder; ?>
<?= $form->open()->action(site_url('edit')) ?>
<?= $form->token() ?>
<?= $form->hidden('edit')->value(1) ?>

<p>
    <?= $form->label('Your Full Name:')->forId('fullname') ?>
    <?= $form->text('fullname')->value($fullname)->id('fullname')->required() ?>
</p>

<p>
    <?= $form->label('Business Name:')->forId('business') ?>
    <?= $form->text('business_name')->value($business_name)->id('business')
        ->placeholder('Business Name Or Your Name')->required() ?>
</p>

<p>
    <?= $form->label('Item Name:')->forId('item') ?>
    <?= $form->text('item_name')->value($item_name)->id('item')
    ->required() ?>
</p>

<p>
    <?= $form->label('Currency:')->forId('currency') ?>
    <?php $currencies = [
        'USD' => 'USD',
        'CAD' => 'CAD',
        'EUR' => 'EUR',
        'GBP' => 'GBP',
        'AUD' => 'AUD',
        'HKD' => 'HKD',
        'SGD' => 'SGD',
        'JPY' => 'JPY',
        'NZD' => 'NZD'
    ] ?>
    <?= $form->select('currency', $currencies)
        ->id('currency')->select($currency) ?>
</p>

<p>
    <?= $form->label(sprintf('%s Amount:', '<span id="currency">' . $currency . '</span>'))
        ->forId('amount') ?>
    <?= $form->number('amount')->step('0.01')->value($amount)->id('amount')
        ->placeholder('99.99')->required() ?>
</p>

<p>
    <?= $form->label('Stripe Publishable Key:')->forId('publishable_key') ?>
    <?= $form->text('publishable_key')->value($publishable_key)->id('publishable_key')
        ->required() ?>
</p>

<p>
    <?= $form->label('Stripe Secret Key:')->forId('secret_key') ?>
    <?= $form->text('secret_key')->value($secret_key)->id('secret_key')
        ->required() ?>
</p>

<p>
    <?= $form->label('Allow Bitcoin Payment?') ?>

    <?php if ($is_bitcoin): ?>
        <?= $form->radio('is_bitcoin', 0) ?> No
    <?php else: ?>
        <?= $form->radio('is_bitcoin', 0)->check() ?> No
    <?php endif ?>

    <?php if ($is_bitcoin): ?>
        <?= $form->radio('is_bitcoin', 1)->check() ?> Yes
    <?php else: ?>
        <?= $form->radio('is_bitcoin', 1) ?> Yes
    <?php endif ?>
</p>

<p>
    <?= $form->submit('Update')->addClass('bold waves-effect btn-large') ?>
</p>