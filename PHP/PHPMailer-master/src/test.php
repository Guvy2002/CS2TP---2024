<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';

$mail->Username = 'gamepointsite@gmail.com';
$mail->Password = 'AppleCatConcrete';

$mail->setFrom('gamepointsite@gmail.com', 'First Last');
//$mail->addReplyTo('cameronmacdonald673@example.com', 'First Last');
$mail->addAddress('cameronmacdonald673@example.com', 'Cameron Macdonald');
$mail->Subject = 'Testing stuff';
$mail->msgHTML(file_get_contents('testemail.html'), __DIR__);
$mail->AltBody = 'This is a plain-text message body';
$mail->addAttachment('a.jpg');

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    }
}
