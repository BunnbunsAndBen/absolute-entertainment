<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');

$pageTitle = 'Home';

?>
<?php include_once($rootDir.'/header.inc.php'); ?>
    </head>
    <body>
        
        <div class="pageHeight">
        
            <?php include($rootDir.'/navbar.inc.php'); ?>

            <section class="hero is-primary is-bold is-medium" style="background: #21768c url('<?= $rootAssetsUrl ?>images/hero.jpg') center center;">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title" style="margin-bottom: 2rem;">
                        Absolute Entertainment
                    </h1>
                    <h2 class="subtitle">
                        We do entertainment.
                    </h2>
                    <div>
                        <a href="<?= $rootUrl ?>contact/" class="button is-primary is-inverted">Contact Us</a>
                    </div>
                </div>
            </div>
            </section>

            <div class="container main-container">

                <!-- <h1 class="title">Absolute Entertainment</h1> -->

            </div><!-- /container -->

        </div><!-- /pageHeight -->
        
        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>