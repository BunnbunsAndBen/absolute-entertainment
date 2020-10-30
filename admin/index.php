<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');

$pageTitle = 'Admin Portal';

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/');
    exit;
}

?>
<?php include_once($rootDir.'/header.inc.php'); ?>
    </head>
    <body>
        
        <div class="pageHeight">
            
            <?php include($rootDir.'/admin/navbar.inc.php'); ?>

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

                <div style="margin-bottom: 10px">
                    <a href="./inbox/" class="button is-outlined is-link">
                        <span class="icon">
                            <span class="material-icons">inbox</span>
                        </span>
                        <span>Contact Inbox</span>
                    </a>
                </div>
                <div style="margin-bottom: 4px">
                    <a href="./reviews/" class="button is-outlined is-link">
                        <span class="icon">
                            <span class="material-icons">comment</span>
                        </span>
                        <span>Reviews</span>
                    </a>
                    <a href="./reviews/create/" class="button is-outlined is-link">Create Review</a>
                </div>
                <div>
                    <a href="./users/" class="button is-outlined is-link">
                        <span class="icon">
                            <span class="material-icons">account_circle</span>
                        </span>
                        <span>User Accounts</span>
                    </a>
                    <a href="./users/register/" class="button is-outlined is-link">Create User</a>
                </div>

            </div><!-- /container -->

        </div><!-- /pageHeight -->

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>