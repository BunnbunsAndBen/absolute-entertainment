<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/users/edit.php');
    exit;
}

$pageTitle = 'Edit User';

$errorMsg = null;
$errorMsgType = 'is-danger';

$userInfo = "";
$userIsSame = ($_SESSION['id'] == trim($_REQUEST['user']));

$password = $confirm_password = "";
$email_hash_err = $password_err = $confirm_password_err = "";

if(empty(trim($_REQUEST['user']))) {
    $user_id_err = true;
    $errorMsg = "No user selected";
}elseif(userIdExists($connection, trim($_REQUEST['user']))) {
    $userInfo = getUserById($connection, trim($_REQUEST['user']));
    if(getUserById($connection, $_SESSION['id'])['type'] != 'admin' && $userInfo['type'] == 'admin') {
        $user_id_err = true;
        $errorMsg = "Only admin can change this user";
    }else {
        $user_id = trim($_REQUEST['user']);
    }
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
        UPDATE users SET password=:password WHERE id=:id
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
<?php include_once($rootDir.'/header.inc.php'); ?>
    </head>
    <body>
        
        <div class="pageHeight">
            
            <?php include($rootDir.'/admin/navbar.inc.php'); ?>

            <!-- <section class="hero is-primary is-bold" style="background: #21768c url('<?= $rootAssetsUrl ?>images/hero.jpg') center center;">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        <?= $pageTitle ?>
                    </h1>
                </div>
            </div>
            </section> -->
            <br>

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

<?php if(!isset($user_id_err)) { ?>

                <div class="box width flex">
                    <span class="material-icons is-size-2" style="margin-right: .5rem" alt="#<?= $userInfo['id'] ?>">person</span>
                    <div>
                        <h1 class="is-size-5"><span title="#<?= $userInfo['id'] ?>"><?= $userInfo['name'] ?><span><?php echo ($userIsSame) ? ' (You)' : ''; ?></span></span></h1>
                        <div class=""><?= $userInfo['email'] ?></div>
                    </div>
                </div>

                <div class="width">
                    <h1 class="is-size-4 mb has-text-light has-text-weight-semibold">New Password</h1>
                </div>

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

<?php }else { ?>

                <div class="block has-text-centered">
                    <a href="./" class="button">Cancel</a>
                </div>

<?php } ?>

            </div><!-- /container -->

        </div><!-- /pageHeight -->

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>