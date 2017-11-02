<?php namespace PH7App; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= getenv('SITE_NAME') ?> &mdash; <?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, user-scalable=no"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,300,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="<?php echo site_url('node_modules/materialize-css/dist/css/materialize.min.css') ?>">
    <link rel="stylesheet" href="<?php echo site_url('node_modules/material-icons/css/material-icons.min.css') ?>">
    <link rel="stylesheet" href="<?php echo site_url('node_modules/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/style.css') ?>">
    <?php include 'analytics.inc.php' ?>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <nav class="light-orange lighten-1" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="<?= site_url() ?>" class="brand-logo"><?= getenv('SITE_NAME') ?></a>
      <ul id="nav-mobile" class="right">
        <?php if (!Core\User::isLoggedIn()): ?>
          <li><a href="<?php echo site_url('signup') ?>" class="yellow-text bold underline">Sign Up</a></li>
          <li><a href="<?php echo site_url('signin') ?>">Sign In</a></li>
        <?php else: ?>
          <li><a href="<?php echo site_url('signout') ?>">Sign Out</a></li>
        <?php endif ?>
      </ul>
    </div>
  </nav>

  <?php if (Core\Route::isHomepage()): ?>
      <header class="section no-pad-bot" id="index-banner">
        <div class="container">
          <h2 class="header center orange-text">Get Stripe Payment Link</h2>
          <div class="row center">
            <h5 class="header col s12 light">Get paid with a simple payment link to share anywhere</h5>
          </div>
        </div>
      </header>
  <?php endif ?>

  <section class="container">
