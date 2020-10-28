<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');
include_once($rootDir.'/db.inc.php');

$pageTitle = 'Contact Us';

$errorMsg = null;
$errorMsgType = 'is-danger';

$name = $email = $phone = $event_date = $location = $payment_type = $message = "";
$name_err = $email_err = $phone_err = $event_date_err = $location_err = $payment_type_err = $message_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Input validateion

    if(empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    }else {
        $name = trim($_POST["name"]);
    }

    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    }else {
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter a phone number.";
    }else {
        $phone = trim($_POST["phone"]);
    }

    if(empty(trim($_POST["event_date"]))) {
        $event_date_err = "Please enter a date for the event.";
    }else {
        $event_date = trim($_POST["event_date"]);
    }

    if(empty(trim($_POST["location"]))) {
        $location_err = "Please enter a location for the event.";
    }else {
        $location = trim($_POST["location"]);
    }

    if(empty(trim($_POST["payment_type"]))) {
        $payment_type_err = "Please select a payment option.";
    }else {
        $payment_type = trim($_POST["payment_type"]);
    }

    if(!empty(trim($_POST["message"]))) {
        $message = trim($_POST["message"]);
    }

    if(empty($name_err) && empty($email_err) && empty($phone_err) && empty($event_date_err) && empty($location_err) && empty($payment_type_err) && empty($message_err)) {

        $new = array(
            "name"  => $name,
            "email" => $email,
            "phone" => $phone,
            "event_date" => $event_date,
            "location" => $location,
            "payment_type" => $payment_type,
            "message" => $message
        );
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "contact",
                implode(", ", array_keys($new)),
                ":" . implode(", :", array_keys($new))
        );

        try {
            $statement = $connection->prepare($sql);
            $statement->execute($new);
            } catch(PDOException $error) {
                $errorMsg = $sql . " " . $error->getMessage();
            }
            
        if(!isset($error)) {
            $name = $email = $phone = $event_date = $location = $payment_type = $message = "";
            $errorMsgType = 'is-success';
            $errorMsg = 'We will contact you soon after we review your information!';
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
                    <div class="notification width <?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
                <?php } ?>

                <form action="." method="post" class="form width box">

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control has-icons-left">
                            <input name="name" class="input <?php echo (!empty($name_err)) ? 'is-danger' : ''; ?>" type="text" value="<?= $name ?>" placeholder="John Doe" required autofocus>
                            <span class="icon is-small is-left">
                            <i class="fa fa-drivers-license"></i>
                            </span>
                            <?php echo (!empty($name_err)) ? '<p class="help is-danger">'.$name_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left">
                            <input name="email" class="input <?php echo (!empty($email_err)) ? 'is-danger' : ''; ?>" type="email" placeholder="me@example.com" value="<?= $email ?>" validate required>
                            <span class="icon is-small is-left">
                            <i class="fa fa-envelope"></i>
                            </span>
                            <?php echo (!empty($email_err)) ? '<p class="help is-danger">'.$email_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Phone number</label>
                        <div class="control has-icons-left">
                            <input name="phone" class="input <?php echo (!empty($phone_err)) ? 'is-danger' : ''; ?>" type="tel" placeholder="(555) 1230-6942" value="<?= $phone ?>" validate required>
                            <span class="icon is-small is-left">
                            <i class="fa fa-phone"></i>
                            </span>
                            <?php echo (!empty($phone_err)) ? '<p class="help is-danger">'.$phone_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Date of event</label>
                        <div class="control has-icons-left">
                            <input name="event_date" class="input <?php echo (!empty($event_date_err)) ? 'is-danger' : ''; ?>" type="date" placeholder="" value="<?= $event_date ?>" validate required>
                            <span class="icon is-small is-left">
                            <i class="fa fa-calendar"></i>
                            </span>
                            <?php echo (!empty($event_date_err)) ? '<p class="help is-danger">'.$event_date_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Location of event</label>
                        <div class="control has-icons-left">
                            <input name="location" class="input <?php echo (!empty($location_err)) ? 'is-danger' : ''; ?>" type="text" placeholder="123 Street Town, State 12345 USA" value="<?= $location ?>" required>
                            <span class="icon is-small is-left">
                            <i class="fa fa-building"></i>
                            </span>
                            <?php echo (!empty($location_err)) ? '<p class="help is-danger">'.$location_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Payment options</label>
                        <div class="control">
                            <div class="select <?php echo (!empty($payment_type_err)) ? 'is-danger' : ''; ?>">
                            <select name="payment_type" value="<?= $payment_type ?>" required>
                                <option value="none" selected disabled hidden>Select payment option</option>
                                <option value="Cash">Cash</option>
                                <option value="Check">Check</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                            </div>
                            <?php echo (!empty($payment_type_err)) ? '<p class="help is-danger">'.$payment_type_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Extra info</label>
                        <div class="control">
                            <textarea name="message" class="textarea <?php echo (!empty($message_err)) ? 'is-danger' : ''; ?>" placeholder="Message" value="<?= $message ?>"></textarea>
                            <?php echo (!empty($message_err)) ? '<p class="help is-danger">'.$message_err.'</p>' : ''; ?>
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

        </div><!-- /container -->

        <?php include($rootDir.'/footer.inc.php'); ?>
    </body>
</html>