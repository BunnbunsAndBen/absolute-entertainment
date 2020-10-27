<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/users/new_password.php');
    exit;
}

$pageTitle = 'New Password';

$errorMsg = null;
$errorMsgType = 'is-danger';

$password = $confirm_password = "";
$email_hash_err = $password_err = $confirm_password_err = "";

if(empty(trim($_REQUEST["user"]))) {
    $user_id_err = true;
    $errorMsg = "No user selected";
}elseif(userIdExists($connection, $_REQUEST['user'])) {
    $user_id = trim($_REQUEST["user"]);
}else {
    $user_id_err = true;
    $errorMsg = "User not found";
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate password
    if(empty(trim($_POST['password']))) {
        $password_err = "Please enter a password.";     
    }elseif(strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must be longer than 6 characters.";
    }else {
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = 'Please confirm password.';     
    }else {
        $confirm_password = trim($_POST['confirm_password']);
        if(trim($_POST['password']) != $confirm_password) {
            $confirm_password_err = 'Passwords did not match.';
        }
    }

    // check for any errors
    if(empty($user_id_err) && empty($password_err) && empty($confirm_password_err)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $new = array(
            "password" => $hashedPassword,
            "id" => $user_id
        );
        $sql = "
        UPDATE userss SET password=:password WHERE id=:id
        ";

        try {
            $statement = $connection->prepare($sql);
            $statement->execute($new);
            } catch(PDOException $error) {
                $errorMsg = $sql . " " . $error->getMessage();
            }
            
        if(!isset($error)) {
            // password changed
            header('Location: ./');
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
                        <li><a href="<?= $rootUrl ?>admin/users/">Users</a></li>
                        <li class="is-active"><a href="./" aria-current="page"><?= $pageTitle ?></a></li>
                    </ul>
                </nav>

                <?php if(isset($errorMsg)) { ?>
                    <div class="notification width <?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
                <?php } ?>

                <form method="post" class="form width box">

                    <div class="field">
                        <label class="label">New Password</label>
                        <div class="control has-icons-left">
                            <input name="password" class="input <?php echo (!empty($password_err)) ? 'is-danger' : ''; ?>" type="password" placeholder="Password" required autofocus>
                            <span class="icon is-small is-left">
                            <i class="fa fa-key"></i>
                            </span>
                            <?php echo (!empty($password_err)) ? '<p class="help is-danger">'.$password_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Confirm Password</label>
                        <div class="control has-icons-left">
                            <input name="confirm_password" class="input <?php echo (!empty($confirm_password_err)) ? 'is-danger' : ''; ?>" type="password" placeholder="Retype Password" required>
                            <span class="icon is-small is-left">
                            <i class="fa fa-key"></i>
                            </span>
                            <?php echo (!empty($confirm_password_err)) ? '<p class="help is-danger">'.$confirm_password_err.'</p>' : ''; ?>
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