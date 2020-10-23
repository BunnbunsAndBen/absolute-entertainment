<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/reviews/');
    exit;
}

$pageTitle = 'Create User';

$errorMsg = null;
$errorMsgType = 'is-danger';

$returnUrl = $_REQUEST['return'];

// logout
if($_GET['action'] == 'logout') {
    $errorMsg = 'Logging out...';
    $_SESSION['auth'] = false;
    $_SESSION = array();
    session_destroy();
    header('Location: '.$rootUrl.$returnUrl);
    exit;
}

$name = $email = $password = $confirm_password = "";
$name_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name
    if(empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    }else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    }elseif(emailExists($connection, $_POST['email'])) {
        $email = trim($_POST["email"]);
        $email_err = "This email is already used.";
    }else {
        $email = $_POST['email'];
    }

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
        if($password != $confirm_password) {
            $confirm_password_err = 'Passwords did not match.';
        }
    }

    // check for any errors
    if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $emailHash = emailHash($email);
        $pfp = pfpFromEmailHash($emailHash);

        $new = array(
            "name"  => $name,
            "email" => $email,
            "emailHash" => $emailHash,
            "password" => $hashedPassword,
            "type" => 'normal',
            "pfp" => $pfp
        );
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
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
                        <li><a href="<?= $rootUrl ?>admin/users/">Users</a></li>
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
                            <input name="name" class="input <?php echo (!empty($name_err)) ? 'is-danger' : ''; ?>" type="text" placeholder="John Doe" value="<?= $name ?>" required <?php echo (!empty($name_err) || (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err))) ? 'autofocus' : ''; ?>>
                            <span class="icon is-small is-left">
                            <i class="fa fa-drivers-license"></i>
                            </span>
                            <?php echo (!empty($name_err)) ? '<p class="help is-danger">'.$name_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left">
                            <input name="email" class="input <?php echo (!empty($email_err)) ? 'is-danger' : ''; ?>" type="email" placeholder="me@example.com" value="<?= $email ?>" required validate <?php echo (!empty($email_err) || (empty($password_err) && empty($confirm_password_err))) ? 'autofocus' : ''; ?>>
                            <span class="icon is-small is-left">
                            <i class="fa fa-envelope"></i>
                            </span>
                            <?php echo (!empty($email_err)) ? '<p class="help is-danger">'.$email_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control has-icons-left">
                            <input name="password" class="input <?php echo (!empty($password_err)) ? 'is-danger' : ''; ?>" type="password" placeholder="Password" required <?php echo ((!empty($password_err) && empty($name_err) && empty($email_err)) || !empty($confirm_password_err)) ? 'autofocus' : ''; ?>>
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