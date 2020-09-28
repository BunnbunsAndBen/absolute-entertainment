<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');

$pageTitle = 'About Us';

?>
<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $pageTitle ?> - <?= $siteTitle ?></title>
        <link rel="icon" type="image/png" href="<?= $rootAssetsUrl ?>images/logo.png">
        <!-- Styles -->
        <link rel="stylesheet" href="<?= $rootAssetsUrl ?>css/default.css"/>
        <link rel="stylesheet" href="<?= $rootAssetsUrl ?>css/global.css"/>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons&family=Roboto&family=Signika:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.1.7/css/fork-awesome.min.css"/>
    </head>
    <body>
        
        <div class="pageHeight">
            
            <?php include($rootDir.'/navbar.inc.php'); ?>

            <section class="hero is-primary is-bold" style="background: #21768c url('<?= $rootAssetsUrl ?>images/hero.jpg') center center;">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        <?= $pageTitle ?>
                    </h1>
                </div>
            </div>
            </section>

            <div class="container main-container">

                <!-- <h1 class="title">Absolute Entertainment</h1> -->

            </div>

        </div>

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>