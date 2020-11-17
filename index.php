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

                <div class="is-size-5 block">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat</p>
                    <br>
                </div>
                <div class="flex">
                    <p class="is-size-5">Cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <span class="flex-grow"></span>
                    <a class="button is-primary" href="<?= $rootUrl ?>about/">Read More</a>
                </div>

            </div><!-- /container -->

        </div><!-- /pageHeight -->
        
        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>