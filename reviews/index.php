<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

$pageTitle = 'Reviews';

$results = getAllReviews($connection);

?>
<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $pageTitle ?> - <?= $siteTitle ?></title>
        <meta name="description" content="<?= $siteDesc ?>">
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

            <?php foreach($results as $row) { ?>

                <div class="card has-background-grey-darker" style="margin-bottom: .5rem">
                    <div class="card-content">
                        <p class="title has-text-light">
                        <?= $row['content'] ?>
                        </p>
                        <p class="subtitle flex" style="margin-top: .25rem">
                        <span><?= $row['name'] ?></span>
                        <span class="flex-grow"></span>
                        <spam><?= formatDate($row['date']) ?></span>
                        </p>
                    </div>
                </div>

            <?php } ?>

            </div>

        </div>

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>