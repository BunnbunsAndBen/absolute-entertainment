<?php
session_start();

// setup
$rootDir = $_SERVER['DOCUMENT_ROOT'];
$rootUrl = '/';
$rootAssetsUrl = $rootUrl.'assets/';

// site vars
$siteTitle = "Absolute Entertainment";
$siteDesc = "We do entertainment. Check us out today!";

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
