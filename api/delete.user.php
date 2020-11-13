<?php

error_reporting(E_ALL & ~E_NOTICE);

include('../global.inc.php');
include('../db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/users/');
    exit;
}

if($_SESSION['id'] == $_GET['id']) {
    $deleteError = "Cannot delete current user";
}

if(getUserById($connection, $_GET['id'])['type'] == 'admin') {
    $deleteError = "Cannot delete admin user";
}



if(isset($deleteError)) {
    $result = array("error" => $deleteError);
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit;
}

try {
    $sql = "DELETE 
                FROM users
                WHERE id = :id
                ";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $_GET['id'], PDO::FETCH_ASSOC);
    $statement->execute();

} catch(PDOException $error) {
    $err = $error->getMessage();
}

if(!isset($error)) {
    $result = array("error" => "ok");
}else {
    $result = array("error" => $err);
}

header('Content-Type: application/json');

if ($_GET['pp']) {
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo json_encode($result);
}
?>