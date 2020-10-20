<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/reviews/');
    exit;
}

$pageTitle = 'Reviews';

$errorMsg = null;
$errorMsgType = 'is-danger';

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

                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                        <li><a href="<?= $rootUrl ?>admin/">Admin Portal</a></li>
                        <li class="is-active"><a href="./" aria-current="page"><?= $pageTitle ?></a></li>
                    </ul>
                </nav>

                <?php if(isset($errorMsg)) { ?>
                    <div class="notification width<?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
                <?php } ?>

                <?php //print_r($results); ?>

                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rating</th>
                            <th>Content</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach($results as $result) { ?>
                        <tr class="r-row">
                            <td><?= $result['id'] ?></td>
                            <td><?= $result['rating'] ?></td>
                            <td><?= $result['content'] ?></td>
                            <td><?= $result['name'] ?></td>
                            <td><?= $result['date'] ?></td>
                            <td><span class="material-icons vam trash" onclick="deleteReview(<?= $result['id'] ?>);" title="Delete review"> delete_forever </span></td>
                            
                        </tr>
<?php } ?>
                    </tbody>
                </table>

                <a href="./create/" class="button is-outlined is-link">Create Review</a>

            </div>

        </div>

        <?php include($rootDir.'/footer.inc.php'); ?>
        <script>
function deleteReview(id) {
    if (confirm("Delete review #"+ id +"?")) {
        console.log('Delete review '+ id);
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var data = JSON.parse(xhttp.responseText);
            if(data.error == 'ok') {
                location.reload();
            }else {
                alert('Error: '+ data.error);
            }
        };
        xhttp.open('GET', '<?= $rootApiUrl ?>delete.review.php?id='+id, true);
        xhttp.send();
    } else {
        
    }
}
        </script>
    </body>
</html>