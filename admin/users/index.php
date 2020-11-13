<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/users/');
    exit;
}

$pageTitle = 'Users';

$errorMsg = null;
$errorMsgType = 'is-danger';

$results = null;

try {
    $sql = "SELECT * 
                    FROM users
                    ORDER BY id DESC
                    ";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $error) {
    $errorMsg = $sql . "<br />" . $error->getMessage();
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
                    <div class="notification width <?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
                <?php } ?>

                <?php //print_r($results); ?>

                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach($results as $result) { ?>
                        <tr class="r-row">
                            <td><?= $result['id'] ?></td>
                            <td><?= $result['name'] ?></td>
                            <td><?= $result['email'] ?></td>
                            <td><?= $result['date'] ?></td>
                            <td><?= $result['type'] ?></td>
                            <td>
                                <a href="./edit.php?user=<?= $result['id'] ?>" class="material-icons vam edit" title="Edit user"> edit </a>
                                &nbsp;
                                <a class="material-icons vam trash" onclick="deleteUser(<?= $result['id'] ?>);" title="Delete user"> delete </a>
                            </td>

                        </tr>
<?php } ?>
                    </tbody>
                </table>

                <a href="./register/" class="button is-outlined is-link">
                    <span class="icon">
                        <span class="material-icons">add</span>
                    </span>
                    <span>Create User</span>
                </a>

            </div><!-- /container -->

        </div><!-- /pageHeight -->

        <?php include($rootDir.'/footer.inc.php'); ?>
    <script>
function deleteUser(id) {
    if (confirm("Delete user #"+ id +"?")) {
        console.log('Delete user '+ id);
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var data = JSON.parse(xhttp.responseText);
            if(data.error == 'ok') {
                location.reload();
            }else {
                alert('Error: '+ data.error);
            }
        };
        xhttp.open('GET', '<?= $rootApiUrl ?>delete.user.php?id='+id, true);
        xhttp.send();
    } else {
        
    }
}
    </script>
    </body>
</html>