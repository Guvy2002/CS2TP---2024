<?php

require_once('dbconnection.php');
ob_start();
include 'header.php';

if(!isset($_SESSION['customerID'])){
	header("Location: homepage.php");
	exit();
}

$error_message = '';
$success_message = '';

$sql = $conn->prepare("SELECT fullName, Email, Password FROM Customer WHERE customerID = ?");
$sql->bind_param("s", $_SESSION['customerID']);
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullName = $row['fullName'];
	$email = $row['Email'];
}

if (isset($_POST['submit'])){
	$fullName = $_POST['fullName'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	try{
    	if (empty($fullName) || empty($email) || empty($password)) {
           throw new Exception("All fields are required");
        }
    	
    	$sql = $conn->prepare("SELECT fullName, Email, Password FROM Customer WHERE customerID = ?");
        $sql->bind_param("s", $_SESSION['customerID']);
        $sql->execute();
        $result = $sql->get_result();
    
        	if ($result->num_rows > 0) {
        		$row = $result->fetch_assoc();
            	if (password_verify($password, $row["Password"])) {
                	$stmt = $conn->prepare("UPDATE Customer SET fullName = ?, Email = ? WHERE customerID = ?");
                	$stmt->bind_param("sss", $fullName, $email, $_SESSION['customerID']);
              		$stmt->execute();
                	$success_message = "Profile updated successfully!";
        		}
				else{
					throw new Exception("Password does not match");
				}
        	} else {
            	throw new Exception("User not found");
            }
    }
    catch (Exception $ex) {
    	$error_message = "Error: " . $ex->getMessage();
    }
}

?>

<section id="My Profile">
    <div class="login-container">
        <h2>My profile</h2>
        <?php
        if (!empty($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
        if (!empty($success_message)) {
            echo '<div class="success-message">' . $success_message . '</div>';
        }
        ?>
        <form id="Password-form" method="POST" action="">
        	<p>Full Name</p>
            <input type="text" name="fullName" value="<?php echo htmlspecialchars($fullName); ?>" required />
        	<p>Email</p>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required />
        	<input type="password" name="password" placeholder="Password" required />
            <div class="button-group">
                <input type="button" name="cancel" value="Cancel"/>
                <input type="submit" name="submit" value="Save" />
            </div>
        </form>
    </div>
</section>

<style>
    .login-container {
    background-color: #f8f8f8; /* Light gray background */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 450px;
    margin: 40px auto;
    text-align: center;
}

/* Input field styles */
#Password-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

#Password-form input[type="email"],
#Password-form input[type="password"],
#Password-form input[type="text"] {
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
#Password-form input[type="password"]:focus,
#Password-form input[type="text"]:focus {
    border-color: #0078d7;
    box-shadow: 0 0 8px rgba(0, 120, 215, 0.3);
}

#Password-form input::placeholder {
    color: #aaa;
    font-style: italic;
}

.button-group {
    display: flex;
    width: 100%;
    gap: 10px;
    justify-content: space-between;
}

/* Button styles */
#Password-form input[type="button"],
#Password-form input[type="submit"] {
    flex: 1;
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

#Password-form input[type="button"] {
    background-color: #6c757d;
}

#Password-form input[type="button"]:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

#Password-form input[type="submit"]:hover {
    background-color: #005bb5;
    transform: translateY(-2px);
}

#Password-form input[type="button"]:active,
#Password-form input[type="submit"]:active {
    transform: translateY(0);
}

/* Error message styling */
.error-message {
    color: #dc3545;
    background-color: #f8d7da;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

/* Success message styling */
.success-message {
    color: #28a745;
    background-color: #d4edda;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

/* Customer login link styling */
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

/* Admin Login Header Styling */
.login-container h2 {
    text-align: center;
    padding-left: 95px;
}
</style>

<?php
include 'footer.php';
?>
            
</html>