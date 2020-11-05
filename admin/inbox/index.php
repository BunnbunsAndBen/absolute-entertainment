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
<?php include_once($rootDir.'/header.inc.php'); ?>
        <style>
            .block:not(:last-child) {
                margin-bottom: 0.75rem;
            }

            .name {
                display: flex;
                align-items: top;
                margin-bottom: 0.25rem;
            }

            .event-date > span,
            .payment > span,
            .location > span {
                vertical-align: middle;
            }

            .contacts {
                display: flex;
                align-items: center;
            }
        </style>
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

<?php if(isset($results[0])) { foreach($results as $result) { ?>

                        <div class="box block r-row">

                            <h1 class="name is-size-4"><span class="has-text-weight-bold"><?= $result['name'] ?></span>&nbsp;<span class="contact-num">[#<?= $result['id'] ?>]</span><span class="flex-grow"></span><a class="material-icons vam trash" onclick="deleteReview(<?= $result['id'] ?>);" title="Delete item"> delete_forever </a></h1>
                            
                            <div class="details block">
                                <span class="event-date" title="Event Date"><span class="material-icons"> event </span>&nbsp;<span class="has-text-weight-semibold"><?= $result['event_date'] ?></span></span>
                                <span class="location" title="Location"><span class="material-icons"> location_on </span>&nbsp;<span class="has-text-weight-semibold"><?= $result['location'] ?></span></span>
                                &nbsp;
                                <span class="payment" title="Payment Type"><span class="material-icons"> payment </span>&nbsp;<span class="has-text-weight-semibold"><?= $result['payment_type'] ?></span></span>
                            </div>

                            <div class="message block" title="Extra Info">
                                <p><?= $result['message'] ?>
                            </div>

                            <div class="contacts block">
                                <span><a href="tel:<?= $result['phone'] ?>"><?= $result['phone'] ?></a></span>&nbsp;&nbsp;&bullet;&nbsp;&nbsp;<span><a href="mailto:<?= $result['email'] ?>"><?= $result['email'] ?></a></span>
                                <span class="flex-grow"></span>
                                <span title="Created at: <?= $result['date'] ?>"><?= $result['date'] ?></span>
                            </div>

                        </div>

<?php } } ?>

                <div style="margin: 1rem 0;">
                    <a href="<?= $rootUrl ?>contact/" class="button is-outlined is-link">
                        <span class="icon">
                            <span class="material-icons">add</span>
                        </span>
                        <span>Create</span>
                    </a>
                </div>
                <div>
                    <a href="./table.php">Table View</a>
                </div>

            </div><!-- /container -->

        </div><!-- /pageHeight -->

        <?php include($rootDir.'/footer.inc.php'); ?>
        <script>
function deleteReview(id) {
    if(confirm("Delete item #"+ id +"?")) {
        console.log('Delete item '+ id);
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
    }else {
        
    }
}
        </script>
    </body>
</html>