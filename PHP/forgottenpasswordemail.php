<?php
ob_start();
include 'header.php';
require_once('dbconnection.php');

$error_message = '';
$success_message = '';

$code = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$customerID = filter_input(INPUT_GET, 'customerID', FILTER_SANITIZE_NUMBER_INT);

if($code == $_SESSION['code']){
	if(isset($_POST['submit'])){
    	$password = $_POST['password'];
    	$confirmPassword = $_POST['confirmPassword'];
    	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		try{
    		if (empty($password) || empty($confirmPassword)) {
           		throw new Exception("All fields are required");
        	} elseif ($password !== $confirmPassword) {
        		throw new Exception("New Passwords do not match");
            } elseif (strlen($password) < 8) {
            	throw new Exception("New password needs to be at least 8 characters long");	
            } else {
	        	$stmt = $conn->prepare("UPDATE Customer SET Password = ? WHERE customerID = ?");
    	        $stmt->bind_param("ss", $hashedPassword, $customerID);
	            $stmt->execute();
    	        $success_message = "Password changed successfully!";
        	}
    	}
    	catch (Exception $ex) {
    		$error_message = "Error: " . $ex->getMessage();
    	}
    }
} else { 
	header('Location: homepage.php');
}	
?>

<section id="Forgotten Password">
    <div class="forggotenPassword-container">
        <h2>Forgotten Password</h2>
        <?php
        if (!empty($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
        if (!empty($success_message)) {
            echo '<div class="success-message">' . $success_message . '</div>';
        }
        ?>
        <form id="Password-form" method="POST" action="">
            <input type="email" name="email" placeholder="Password" required />
            <input type="email" name="email" placeholder="Confirm Password" required />
        	<input type="submit" name="submit" value="Send Email" />
        </form>
    </div>
</section>
        
<?php
include 'footer.php';
ob_end_flush();
?>

<style> 
.forggotenPassword-container {
    background-color: #f8f8f8;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 450px;
    margin: 40px auto;
    text-align: center;
}

#Password-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

#Password-form input[type="email"] {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

#Password-form input[type="email"]:focus {
    border-color: #0078d7;
    box-shadow: 0 0 8px rgba(0, 120, 215, 0.3);
}

#Password-form input::placeholder {
    color: #aaa;
    font-style: italic;
}

#Password-form input[type="submit"] {
    width: 100%;
    padding: 12px 15px;
    margin-top: 10px;
    background-color: #0078d7;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

#Password-form input[type="submit"]:hover {
    background-color: #005bb5;
    transform: translateY(-2px);
}

#Password-form input[type="submit"]:active {
    transform: translateY(0);
}

.forggotenPassword-container h2 {
    text-align: center;
    margin-bottom: 15px;
}

.error-message {
    color: #dc3545;
    background-color: #f8d7da;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.success-message {
    color: #155724;
    background-color: #d4edda;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}
</style>