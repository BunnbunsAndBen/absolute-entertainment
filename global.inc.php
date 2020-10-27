<?php
session_start();
$errorMsg = '';

// setup
$rootDir = $_SERVER['DOCUMENT_ROOT'];
$rootUrl = '/';
$rootAssetsUrl = $rootUrl.'assets/';
$rootApiUrl = $rootUrl.'api/';

// site vars
$siteTitle = "Absolute Entertainment";
$siteDesc = "We do entertainment. Check us out today!";
$siteEmail = "sales@absoluteentertainment.com";

// logged in?
if(isset($_SESSION['auth'])) {
    $loggedIn = true;
}else {
    $loggedIn = false;
}

// escape HTML function
function escape($html) {
	return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

// date format function
function formatDate($date, $type = null) {
    $spacer = ' at ';
    $newDate = date("M j, Y", strtotime($date));
    $time = date("H:i T", strtotime($date));
    if($type == 'time') {
        $formatedDate = $newDate.$spacer.$time;
    }else {
        $formatedDate = $newDate;
    }
    return $formatedDate;
}

// create md5 hash of email
function emailHash($email) {
    $email = trim($email);
    $emailHash = md5(strtolower($email));
    return $emailHash;
}

// create pfp link with hash for gravatar
function pfpFromEmailHash($emailHash, $default = 'mp') {
    return 'https://www.gravatar.com/avatar/'.$emailHash.'?d='.$default;
}

// create pfp link via email for gravatar
function pfpFromEmail($email, $default = 'mp') {
    $emailHash = emailHash($email);
    return pfpFromEmailHash($emailHash, $default);
}

// -- db functions -- //

function userIdExists($connection, $userId) {
    $stmt = $connection->prepare("SELECT 1 FROM users WHERE id=?");
    $stmt->execute([$userId]); 
    return $stmt->fetchColumn();
}

function emailExists($connection, $email) {
    $stmt = $connection->prepare("SELECT 1 FROM users WHERE email=?");
    $stmt->execute([$email]); 
    return $stmt->fetchColumn();
}

function emailHashExists($connection, $emailHash) {
    $stmt = $connection->prepare("SELECT 1 FROM users WHERE email_hash=?");
    $stmt->execute([$emailHash]); 
    return $stmt->fetchColumn();
}

function getUserById($connection, $id) {
    // read from db table
    try {
        $sql = "SELECT * 
                        FROM users
                        WHERE id = :id
                        ";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, PDO::FETCH_ASSOC);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $error) {
        $errorMsg = $sql . "<br />" . $error->getMessage();
    }
    // return results
    return $result[0];
}

function getAllReviews($connection) {
    // read from db table
    try {
        $sql = "SELECT * 
                        FROM reviews
                        ORDER BY id DESC
                        ";

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $error) {
        $errorMsg = $sql . "<br />" . $error->getMessage();
    }
    // return results
    return $result;
}