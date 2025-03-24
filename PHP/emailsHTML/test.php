<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

$mail = new PHPMailer(true);
try {
	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'gamepointsite@gmail.com';
    $mail->Password   = 'mboj vicn pgpq jvrr';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
       
    $mail->setFrom('gamepointsite@gmail.com', 'GamePoint Site');
    $mail->addAddress("cameronmacdonald673@gmail.com");
    require_once ('newsletterphp.php');
    $mail->msgHTML(file_get_contents('newsletter.php'));
        
    if (!$mail->send()) {
    	echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
    	echo 'Message sent!';
    }
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>