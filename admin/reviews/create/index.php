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
    
    // Validate rating
    if(empty(trim($_POST["rating"]))) {
        $rating_err = "Please add a rating.";
    }else {
        $rating = trim($_POST["rating"]);
    }

    // Validate content
    $content = trim($_POST["content"]);

    // check for any errors
    if(empty($name_err) && empty($content_err) && empty($rating_err)) {

        $new = array(
            "name"  => $name,
            "rating" => $rating,
            "content" => $content,
            "added_by" => $_SESSION['id']
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
                $errorMsg = $sql . " " . $error->getMessage();
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
                        <li><a href="<?= $rootUrl ?>admin/reviews/">Reviews</a></li>
                        <li class="is-active"><a href="./" aria-current="page"><?= $pageTitle ?></a></li>
                    </ul>
                </nav>

                <?php if(isset($errorMsg)) { ?>
                    <div class="notification width <?= $errorMsgType ?>" style="margin: 0 auto .75rem auto;"><?= $errorMsg ?></div>
                <?php } ?>

                <form method="post" class="form width box">

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control has-icons-left">
                            <input name="name" class="input <?php echo (!empty($name_err)) ? 'is-danger' : ''; ?>" value="<?= $_POST['name'] ?>" required autofocus>
                            <span class="icon is-small is-left">
                            <i class="fa fa-drivers-license"></i>
                            </span>
                            <?php echo (!empty($name_err)) ? '<p class="help is-danger">'.$name_err.'</p>' : ''; ?>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Rating</label>
                        <div class="control has-icons-left">
                            <input name="rating" type="number" min="1" max="5" class="input <?php echo (!empty($rating_err)) ? 'is-danger' : ''; ?>" value="<?= $_POST['rating'] ?>" required>
                            <span class="icon is-small is-left">
                            <i class="fa fa-star"></i>
                            </span>
                            <?php echo (!empty($rating_err)) ? '<p class="help is-danger">'.$rating_err.'</p>' : ''; ?>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Comment</label>
                        <div class="control">
                            <textarea name="content" class="textarea <?php echo (!empty($content_err)) ? 'is-danger' : ''; ?>" placeholder="Content of review"><?= escape($_POST['content']) ?></textarea>
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