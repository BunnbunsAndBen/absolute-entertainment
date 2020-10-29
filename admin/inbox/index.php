<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/inbox/');
    exit;
}

$pageTitle = 'Contact Inbox';

$errorMsg = null;
$errorMsgType = 'is-danger';

$results = getInbox($connection);

if(!isset($results[0])) {
    $errorMsgType = 'is-info';
    $errorMsg = 'Nothing yet';
}

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
                    <div class="notification <?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
                <?php } ?>

                <?php //print_r($results); ?>

                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Event Date</th>
                            <th>Locatoin</th>
                            <th>Message</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Payment Type</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
<?php if(isset($results[0])) { foreach($results as $result) { ?>
                        <tr class="r-row">
                            <td><?= $result['id'] ?></td>
                            <td><?= $result['name'] ?></td>
                            <td><?= $result['event_date'] ?></td>
                            <td><?= $result['location'] ?></td>
                            <td><?= $result['message'] ?></td>
                            <td><?= $result['phone'] ?></td>
                            <td><a href="mailto:<?= $result['email'] ?>"><?= $result['email'] ?></a></td>
                            <td><?= $result['payment_type'] ?></td>
                            <td><?= $result['date'] ?></td>
                            <td><a class="material-icons vam trash" onclick="deleteReview(<?= $result['id'] ?>);" title="Delete review"> delete_forever </a></td>
                            
                        </tr>
<?php } } ?>
                    </tbody>
                </table>

                <a href="<?= $rootUrl ?>contact/" class="button is-outlined is-link">
                    <span class="icon">
                        <span class="material-icons">add</span>
                    </span>
                    <span>Create</span>
                </a>

            </div>

        </div>

        <?php include($rootDir.'/footer.inc.php'); ?>
        <script>
function deleteReview(id) {
    if (confirm("Delete contact #"+ id +"?")) {
        console.log('Delete contact '+ id);
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var data = JSON.parse(xhttp.responseText);
            if(data.error == 'ok') {
                location.reload();
            }else {
                alert('Error: '+ data.error);
            }
        };
        xhttp.open('GET', '<?= $rootApiUrl ?>delete.contact.php?id='+id, true);
        xhttp.send();
    } else {
        
    }
}
        </script>
    </body>
</html>