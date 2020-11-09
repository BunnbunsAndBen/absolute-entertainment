<?php

error_reporting(E_ALL & ~E_NOTICE);

include('../global.inc.php');
include('../db.inc.php');

try {
    $connection = new PDO($sql_dsn, $sql_username, $sql_password, $sql_options);
    $sql = "SELECT * 
                FROM reviewss
                ";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $error) {
    $err = $error->getMessage();
}

header('Content-Type: application/json');
 
echo json_encode($err, JSON_PRETTY_PRINT);

echo json_encode($result, JSON_PRETTY_PRINT);
?>