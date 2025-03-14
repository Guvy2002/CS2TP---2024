<?php

require_once('dbconnection.php');
ob_start();
include 'header.php';

$error_message = '';
$success_message = '';

if(!isset($_SESSION['customerID'])){
	header("Location: homepage.php");
	exit();
}

if (isset($_POST['submit'])){
	$old_password = $_POST['oldPassword'];
	$new_password = $_POST['newPassword'];
	$confirm_password = $_POST['confirmPassword'];
	$hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
	$sql = $conn->prepare("SELECT Password FROM Customer WHERE customerID = ?");
    $sql->bind_param("s", $_SESSION['customerID']);
    $sql->execute();
    $result = $sql->get_result();

	try{
    	if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
           throw new Exception("All fields are required");
        }
    	elseif ($new_password !== $confirm_password) {
        	throw new Exception("New passwords do not match");
        }
    	elseif (strlen($new_password) < 8) {
           throw new Exception("New password needs to be at least 8 characters long");
        }
    	else {
        	if ($result->num_rows > 0) {
        		$row = $result->fetch_assoc();
            	if (password_verify($old_password, $row["Password"])) {
                	$stmt = $conn->prepare("UPDATE Customer SET Password = ? WHERE customerID = ?");
                	$stmt->bind_param("ss", $hashedPassword, $_SESSION['customerID']);
              		$stmt->execute();
                	$success_message = "Password changed successfully!";
        		}
				else{
					throw new Exception("Old Password does not match");
				}
        	}
        }
    }
    catch (Exception $ex) {
    	$error_message = "Error: " . $ex->getMessage();
    }
}

?>

<section id="Change Password">
    <div class="login-container">
        <h2>Change Password</h2>
        <?php
        if (!empty($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
        if (!empty($success_message)) {
            echo '<div class="success-message">' . $success_message . '</div>';
        }
        ?>
        <form id="Password-form" method="POST" action="">
            <input type="password" name="oldPassword" placeholder="Current Password" required />
            <input type="password" name="newPassword" placeholder="New Password" required />
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required />
            <input type="submit" name="submit" value="Change Password" />
        </form>
    </div>
</section>

<style>
    .login-container {
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

#Password-form input[type="email"],
#Password-form input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

#Password-form input[type="email"]:focus,
#Password-form input[type="password"]:focus {
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

.error-message {
    color: #dc3545;
    background-color: #f8d7da;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.success-message {
    color: #28a745;
    background-color: #d4edda;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.customer-link {
    font-size: 14px;
    text-align: center;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #ddd;
}

.customer-link a {
    color: #0078d7;
    text-decoration: none;
}

.customer-link a:hover {
    text-decoration: underline;
}

.login-container h2 {
    text-align: center;
    padding-left: 95px;
}
</style>

<?php
include 'footer.php';
?>
            
</html>