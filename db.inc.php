<?php
$sql_host       = "localhost";
$sql_username   = "admin";
$sql_password   = "e94q0GMZ7BrO0SC3";
$sql_dbname     = "ae";
$sql_dsn        = "mysql:host=$sql_host;dbname=$sql_dbname";
$sql_options    = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
$connection = new PDO($sql_dsn, $sql_username, $sql_password, $sql_options);
?>
