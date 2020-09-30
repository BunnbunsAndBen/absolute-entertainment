<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');

$pageTitle = 'Contact Us';

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

                <form class="form box">

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" placeholder="John Doe" required autofocus>
                            <span class="icon is-small is-left">
                            <i class="fa fa-drivers-license"></i>
                            </span>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left">
                            <input class="input" type="email" placeholder="me@example.com" required validate>
                            <span class="icon is-small is-left">
                            <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Phone number</label>
                        <div class="control has-icons-left">
                            <input class="input" type="tel" placeholder="(555) 1230-6942" validate>
                            <span class="icon is-small is-left">
                            <i class="fa fa-phone"></i>
                            </span>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Date of event</label>
                        <div class="control has-icons-left">
                            <input class="input" type="date" placeholder="" validate required>
                            <span class="icon is-small is-left">
                            <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Location of event</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" placeholder="123 Street Town, State 12345 USA" required>
                            <span class="icon is-small is-left">
                            <i class="fa fa-building"></i>
                            </span>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Payment options</label>
                        <div class="control">
                            <div class="select">
                            <select required>
                                <option>Select payment option</option>
                                <option>Cash</option>
                                <option>Check</option>
                                <option>Credit Card</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Extra info</label>
                        <div class="control">
                            <textarea class="textarea" placeholder="Message"></textarea>
                        </div>
                    </div>

                    <div class="field is-grouped is-grouped-right">
                        <p class="control">
                            <button type="submit" class="button is-link">
                            Submit
                            </button>
                        </p>
                    </div>

                </form>

            </div>

        </div><!-- /container -->

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>