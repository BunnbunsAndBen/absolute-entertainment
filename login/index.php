<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

$pageTitle = 'Sign in';

$errorMsg = null;
$errorMsgType = 'is-danger';

$returnUrl = $_REQUEST['return'];

if(empty($returnUrl)) {
    $returnUrl = 'admin';
}

// logout
if($_GET['action'] == 'logout') {
    $errorMsg = 'Logging out...';
    $_SESSION['auth'] = false;
    $_SESSION = array();
    session_destroy();
    header('Location: '.$rootUrl.$returnUrl);
    exit;
}

// logged in redirect
if($_SESSION['auth']) {
    $errorMsgType = 'is-success';
    $errorMsg = 'Signed in!';
    $returnUrl = 'admin';
    header('Location: '.$rootUrl.$returnUrl);
    exit;
}

$email = $password = "";
$email_err = $password_err = "";

// form sumbited
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate user exists
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    }elseif(!emailExists($connection, $_POST['email'])) {
        $email = trim($_POST["email"]);
        $email_err = "User does not exist.";
    }else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if(empty(trim($_POST['password']))) {
        $password_err = "Please enter a password.";     
    }else {
        $password = trim($_POST['password']);
    }

    // check for any errors
    if(empty($email_err) && empty($password_err)) {

        //Check password by username
        $sql = "SELECT id, name, email, pfp, password, type
        FROM users
        WHERE email = :email";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $email, PDO::FETCH_ASSOC);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC)[0];

        if (password_verify($password, $data['password'])) {
            //good, create session
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $data['id'];
            $_SESSION['name'] = $data['name'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['pfp'] = $data['pfp'];
            $_SESSION['type'] = $data['type'];
            //
            $errorMsgType = 'is-success';
            $errorMsg = 'Signed in!';
            header('Location: '.$rootUrl.$returnUrl);
            exit;
        }else {
            //bad
            $password_err = "Invalid password.";
        }

    }

}
?>
<?php include_once($rootDir.'/header.inc.php'); ?>
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

                <?php if(isset($errorMsg)) { ?>
                    <div class="notification width sm <?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
                <?php } ?>

                <form method="post" class="form width sm box">

                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left">
                            <input name="email" class="input <?php echo (!empty($email_err)) ? 'is-danger' : ''; ?>" type="email" placeholder="me@example.com" value="<?= $email ?>" required validate <?php echo ((empty($email_err) && empty($password_err)) || !empty($email_err)) ? 'autofocus' : ''; ?>>
                            <span class="icon is-small is-left">
                            <i class="fa fa-envelope"></i>
                            </span>
                            <?php echo (!empty($email_err)) ? '<p class="help is-danger">'.$email_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control has-icons-left">
                            <input name="password" class="input <?php echo (!empty($password_err)) ? 'is-danger' : ''; ?>" type="password" placeholder="Password" required <?php echo ((!empty($password_err) && empty($email_err)) || empty($email_err)) ? 'autofocus' : ''; ?>>
                            <span class="icon is-small is-left">
                            <i class="fa fa-key"></i>
                            </span>
                            <?php echo (!empty($password_err)) ? '<p class="help is-danger">'.$password_err.'</p>' : ''; ?>
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

            </div><!-- /container -->

        </div><!-- /pageHeight -->

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>