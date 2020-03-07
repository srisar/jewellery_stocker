<?php

use Jman\core\App;
use Jman\core\LoginManager;

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= App::getSiteURL() ?>/assets/styles/bootstrap.min.css">

    <link rel="stylesheet" href="<?= App::getSiteURL() ?>/assets/plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="<?= App::getSiteURL() ?>/assets/plugins/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?= App::getSiteURL() ?>/assets/styles/app.css">

    <title><?= APP_NAME ?></title>
</head>
<?php include_once BASE_PATH . '/views/_top_nav.inc.php'; ?>

<div class="mb-3"></div>
