<?php

include('../global.inc.php');
include('../db.inc.php');

// logged in?
if(!$loggedIn) {
    header('Location: '.$rootUrl.'login/?return=admin/reviews/');
    exit;
}

//read from db table //
try {
    $sql = "DELETE 
                FROM reviews
                WHERE id = :id
                ";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $_GET['id'], PDO::FETCH_ASSOC);
    $statement->execute();
} catch(PDOException $error) {
    echo $sql . "<br />" . $error->getMessage();
}
if(!isset($error)) {
    $result = array("error" => "ok");
}
// page //
header('Content-Type: application/json');

echo json_encode($result, JSON_PRETTY_PRINT);
?>