<?php
require_once("dbconnection.php");

if (isset($_POST['submit'])) {
   $name = trim($_POST['name']);
   $email = trim($_POST['email']);
   $password = $_POST['password'];
   $confirm_password = $_POST['confirm_password'];
   $registration_date = date("Y-m-d");

   try {
       // Validate inputs
       if (empty($name) || empty($email) || empty($password)) {
           throw new Exception("All fields are required");
       }

       if ($password !== $confirm_password) {
           throw new Exception("Passwords do not match");
       }

       if (strlen($password) < 8) {
           throw new Exception("Password needs to be at least 8 characters long");
       }

       // Hash password after validation
       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

       // Check if email already exists
       $checkEmail = $conn->prepare("SELECT Email FROM Customer WHERE Email = ?");
       $checkEmail->bind_param("s", $email);
       $checkEmail->execute();
       $result = $checkEmail->get_result();
       
       if ($result->num_rows > 0) {
           throw new Exception("Email already exists");
       }

       // Insert new customer
       $stmt = $conn->prepare("INSERT INTO Customer (fullName, Email, Password, RegistrationDate) VALUES (?, ?, ?, ?)");
       $stmt->bind_param("ssss", $name, $email, $hashedPassword, $registration_date);
       
       if ($stmt->execute()) {
           // After successful insert, get the customerID
           $customerIDs = "SELECT Email, customerID FROM Customer";
           $customerIDsResult = $conn->query($customerIDs);
           
           if ($customerIDsResult->num_rows > 0) {
               while ($row = $customerIDsResult->fetch_assoc()) {
                   if ($row['Email'] == $email) {
                       $customerID = $row['customerID'];
                       setcookie('customerID', $customerID, time() + (86400 * 30), "/");
                   }
               }
           }
           
           header("Location: homepage.php");
           exit();
       } else {
           throw new Exception("Error creating account");
       }
   }
   catch (Exception $e) {
       $error_message = $e->getMessage();
   }
}

include 'header.php';
?>

<section id="sign-up">
   <h2>Register</h2>
   <?php if(isset($error_message)): ?>
       <div class='error'><?php echo $error_message; ?></div>
   <?php endif; ?>
   <form id="login-form" class="form-login" method="POST" action="">
       <label for="name">Full name:</label>
       <input type="text" id="name" name="name" required>

       <label for="email">Email:</label>
       <input type="email" id="email" name="email" required>

       <label for="password">Password:</label>
       <input type="password" id="password" name="password" required>

       <label for="confirm_password">Confirm Password:</label>
       <input type="password" id="confirm-password" name="confirm_password" required>

       <button class="login-button" type="submit" name="submit">Sign Up</button>
   </form>
   <div class="register-user">
       <p>Already have an account? <a href="login.php">Login here</a></p>
   </div>
</section>

<?php
include 'footer.php';
?>