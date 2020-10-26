<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once($_SERVER['DOCUMENT_ROOT'].'/global.inc.php');

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
  //Server settings
  $mail->isSMTP();
  $mail->Host       = $siteSMTP_url;
  $mail->SMTPAuth   = true;
  $mail->Username   = $siteSMTP_user;
  $mail->Password   = $siteSMTP_pwd;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port       = 587;

  //Recipients
  $mail->setFrom($siteEmail, $siteTitle);
  $mail->addAddress($_REQUEST['email']);

  // Content
  $mail->isHTML(true);
  $mail->Subject = 'Here is the subject';
  $mail->Body    = 'This is the HTML message body <b>in bold!</b>';

  $mail->send();
  echo 'Message has been sent';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}