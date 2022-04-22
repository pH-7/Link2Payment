<?php namespace PH7App; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title; ?> &mdash; <?= $_ENV['SITE_NAME'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, user-scalable=no"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,300,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="<?= site_url('node_modules/materialize-css/dist/css/materialize.min.css') ?>">
    <link rel="stylesheet" href="<?= site_url('node_modules/material-icons/css/material-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('css/style.css') ?>">

    <?php if (!empty($_ENV['GOOGLE_ANALYTICS_ID'])): ?>
      <?php include 'analytics.inc.php' ?>
    <?php endif ?>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<?php if (!Core\Route::isStripePage()): ?>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="<?= site_url() ?>" class="brand-logo"><?= $_ENV['SITE_NAME'] ?></a>
      <ul id="nav-mobile" class="right">
        <?php if (!Core\User::isLoggedIn()): ?>
          <li <?= Core\Route::doesContain('signup') ? 'class="active"' : '' ?>>
            <a href="<?= site_url('signup') ?>" class="underline bold red-text text-lighten-3">
              Sign Up
            </a>
          </li>
          <li <?= Core\Route::doesContain('signin') ? 'class="active"' : '' ?>>
            <a href="<?= site_url('signin') ?>">
              Sign In
            </a>
          </li>
        <?php else: ?>
          <li <?= Core\Route::doesContain('edit') ? 'class="active"' : '' ?>>
            <a href="<?= site_url('edit') ?>">
              Edit Details
            </a>
          </li>
          <li <?= Core\Route::doesContain('password') ? 'class="active"' : '' ?> >
            <a href="<?= site_url('password') ?>">
              Change Password
            </a>
          </li>
          <li>
            <a href="<?= site_url('signout') ?>">
              Sign Out
            </a>
          </li>
        <?php endif ?>
      </ul>
    </div>
  </nav>

  <?php if (Core\Route::isHomePage()): ?>
      <header class="section no-pad-bot" id="index-banner">
        <div class="container">
          <h2 class="header center orange-text">Get your Stripe Payment Link</h2>
          <div class="row center">
            <h5 class="header col s12 light">Get paid with just a simple link to share anywhere with anyone!</h5>
          </div>
        </div>
      </header>
  <?php endif ?>
<?php endif ?>

  <section class="container center-block container-margin">
