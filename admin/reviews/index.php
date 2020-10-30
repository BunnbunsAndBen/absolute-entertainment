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

if(!isset($results[0])) {
    $errorMsgType = 'is-info';
    $errorMsg = 'No reviews yet';
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

                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                        <li><a href="<?= $rootUrl ?>admin/">Admin Portal</a></li>
                        <li class="is-active"><a href="./" aria-current="page"><?= $pageTitle ?></a></li>
                    </ul>
                </nav>

                <?php if(isset($errorMsg)) { ?>
                    <div class="notification <?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
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
<?php if(isset($results[0])) { foreach($results as $result) { ?>
                        <tr class="r-row">
                            <td><?= $result['id'] ?></td>
                            <td><?= $result['rating'] ?></td>
                            <td><?= $result['content'] ?></td>
                            <td><?= $result['name'] ?></td>
                            <td><?= $result['date'] ?></td>
                            <td><a class="material-icons vam trash" onclick="deleteReview(<?= $result['id'] ?>);" title="Delete review"> delete_forever </a></td>
                            
                        </tr>
<?php } } ?>
                    </tbody>
                </table>

                <a href="./create/" class="button is-outlined is-link">
                    <span class="icon">
                        <span class="material-icons">add</span>
                    </span>
                    <span>Create Review</span>
                </a>

            </div><!-- /container -->

        </div><!-- /pageHeight -->

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