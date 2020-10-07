<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/reviews/create/');
    exit;
}

$pageTitle = 'Create Review';

$errorMsg = null;
$errorMsgType = 'is-danger';

$name = $rating = $content = "";
$name_err = $rating_err = $content_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name
    if(empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    }else {
        $name = trim($_POST["name"]);
    }

    // check for any errors
    if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $emailHash = emailHash($email);

        $new = array(
            "name"  => $name,
            "rating" => $rating,
            "content" => $content,
            "username" => $_SESSION['username']
        );
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "reviews",
                implode(", ", array_keys($new)),
                ":" . implode(", :", array_keys($new))
        );

        try {
            $statement = $connection->prepare($sql);
            $statement->execute($new);
            } catch(PDOException $error) {
                echo $sql . " " . $error->getMessage();
            }
            
        if(!isset($error)) {
            // user created
            header('Location: ../');
            exit;
        }
    }else {
        //$errorMsg = 'Please fill out the form correctly.';
    }

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
                        <li><a href="<?= $rootUrl ?>admin/reviews/">Reviews</a></li>
                        <li class="is-active"><a href="./" aria-current="page"><?= $pageTitle ?></a></li>
                    </ul>
                </nav>

                <?php if(isset($errorMsg)) { ?>
                    <div class="notification width<?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
                <?php } ?>

                <form method="post" class="form width box">

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control has-icons-left">
                            <input name="name" class="input <?php echo (!empty($name_err)) ? 'is-danger' : ''; ?>" type="text" placeholder="John Doe" required <?php echo (!empty($name_err) || (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err))) ? 'autofocus' : ''; ?>>
                            <span class="icon is-small is-left">
                            <i class="fa fa-drivers-license"></i>
                            </span>
                            <?php echo (!empty($name_err)) ? '<p class="help is-danger">'.$name_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Comment</label>
                        <div class="control">
                            <textarea class="textarea" placeholder="Content of review"></textarea>
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

        </div>

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>