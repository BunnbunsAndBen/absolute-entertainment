<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

$pageTitle = 'Reviews';

$errorMsg = null;
$errorMsgType = 'is-danger';

$results = getAllReviews($connection);

if(!isset($results[0])) {
    $errorMsgType = 'is-info';
    $errorMsg = 'No reviews yet';
}

?>
<?php include_once($rootDir.'/header.inc.php'); ?>
        <style>
            .stars {
                margin-bottom: .5rem;
            }
            .unfilledStar {
                color: rgba(245, 245, 245, .55);
            }
        </style>
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

            <?php if(isset($errorMsg)) { ?>
                <div class="notification <?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
            <?php } ?>

            <?php if(isset($results[0])) { foreach($results as $row) { ?>

                <div class="card has-background-grey-darker" style="margin-bottom: .5rem">
                    <div class="card-content">
                        <div class="stars has-text-light">
                            <?php
                            $i = 0;
                            $stars = ceil($row['rating']);
                            $starsOutOf5 = 5 - $stars;
                            while ($i++ < $stars) {
                                echo '<span class="material-icons has-text-warning"> star </span>';
                            }
                            $i = 0;
                            while ($i++ < $starsOutOf5) {
                                echo '<span class="material-icons unfilledStar"> star </span>';
                            }
                            ?>
                        </div>
                        <p class="title has-text-light">
                        <?= $row['content'] ?>
                        </p>
                        <p class="subtitle flex" style="margin-top: .25rem">
                        <span>-&nbsp;<?= $row['name'] ?></span>
                        <span class="flex-grow"></span>
                        <span><?= formatDate($row['date']) ?></span>
                        </p>
                    </div>
                </div>

            <?php } } ?>

            </div><!-- /container -->

        </div><!-- /pageHeight -->

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>