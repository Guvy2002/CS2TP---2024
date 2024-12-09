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
<style>
    #sign-up {
       max-width: 500px;
       margin: 0 auto;
       padding: 20px;
       border: 1px solid #ccc;
       border-radius: 8px;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   }

   #sign-up h2 {
       text-align: center;
       margin-bottom: 20px;
       font-family: Arial, sans-serif;
   }

   #sign-up .error {
       color: red;
       margin-bottom: 15px;
       text-align: center;
   }

   #login-form label {
       font-weight: bold;
       margin-top: 10px;
       display: block;
       font-family: Arial, sans-serif;
   }

   #login-form input {
       width: 100%;
       padding: 10px;
       margin: 8px 0;
       border: 1px solid #ccc;
       border-radius: 6px;
       font-size: 14px;
   }

   #login-form input:focus {
       border-color: #0078d7;
       box-shadow: 0 0 8px rgba(0, 120, 215, 0.3);
   }

   .login-button {
       width: 100%;
       background-color: #0078d7;
       color: white;
       padding: 10px 15px;
       border: none;
       border-radius: 6px;
       font-size: 16px;
       cursor: pointer;
       transition: background-color 0.3s ease;
   }

   .login-button:hover {
       background-color: #005bb5;
   }

   .register-user {
       text-align: center;
       margin-top: 10px;
   }

   .register-user a {
       color: #0078d7;
       text-decoration: none;
   }

   .register-user a:hover {
       text-decoration: underline;
   }
</style>
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