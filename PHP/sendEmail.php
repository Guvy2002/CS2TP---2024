<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';
require_once('dbconnection.php');

$contents = filter_input(INPUT_GET, 'contents', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$orderID = filter_input(INPUT_GET, 'orderID', FILTER_SANITIZE_NUMBER_INT);
$customerID = filter_input(INPUT_GET, 'customerID', FILTER_SANITIZE_NUMBER_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$redirect = filter_input(INPUT_GET, 'redirect', FILTER_SANITIZE_URL);
$emailSent = false;
$errorMessage = '';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
}

if ($orderID) {
    $_GET['orderID'] = $orderID;
}

if (isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];
} 

if (isset($_SESSION['code'])) {
    $code = $_SESSION['code'];
} 



if(isset($email) || isset($customerID)){
	if(isset($customerID)){
    	$sql = $conn->prepare("SELECT fullName, Email FROM Customer WHERE customerID = ?");
    	$sql->bind_param("i", $customerID);
    	$sql->execute();
    	$result = $sql->get_result();
		if ($result->num_rows > 0) {
        	$row = $result->fetch_assoc();
        	$fullName = $row["fullName"];
        	$email = $row["Email"];
        }
    } else {
    	$fullName = 'Newsletter Subscriber';
    }
        
	$mail = new PHPMailer(true);
        
    try {
    	$mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gamepointsite@gmail.com';
        $mail->Password = 'mboj vicn pgpq jvrr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('gamepointsite@gmail.com', 'GamePoint Site');
        $mail->addAddress($email, $fullName);
            
        if (file_exists('emailsHTML/' . $contents . 'php.php')) {
        	require_once('emailsHTML/' . $contents . 'php.php');
        } else {
        	throw new Exception("Email template PHP file not found: emailsHTML/" . $contents . "php.php");
        }
            
        if (file_exists('emailsHTML/' . $contents . '.php')) {
        	ob_start();
            include('emailsHTML/' . $contents . '.php');
            $emailContent = ob_get_clean();
            $mail->msgHTML($emailContent);
        } else {
        	throw new Exception("Email HTML template not found: emailsHTML/" . $contents . ".php");
        }
    
        if ($mail->send()) {
        	$emailSent = true;
               
            if ($orderID) {
            	$_SESSION['email_sent_for_order'] = $orderID;
            }
        } else {
        	$errorMessage = 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
    	$errorMessage = "Message could not be sent. Error: " . $e->getMessage();
    }
} else {
	$errorMessage = "Error: Customer or email not found";
}

if ($emailSent && $redirect && !empty($redirect)) {
    header("Location: " . $redirect);
    exit();
} else {
    if ($emailSent) {
        echo 'Email sent successfully!';
    } else {
        echo $errorMessage;
    }
}
?>