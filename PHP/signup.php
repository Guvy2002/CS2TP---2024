<?php
require_once("dbconnection.php");

if (isset($_POST['submit'])) {
   $name = trim($_POST['name']);
   $email = trim($_POST['email']);
   $password = $_POST['password'];
   $confirm_password = $_POST['confirm_password'];
   $registration_date = date("Y-m-d");

   try {
       if (empty($name) || empty($email) || empty($password)) {
           throw new Exception("All fields are required");
       }
       if ($password !== $confirm_password) {
           throw new Exception("Passwords do not match");
       }
       if (strlen($password) < 8) {
           throw new Exception("Password needs to be at least 8 characters long");
       }
       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
       $checkEmail = $conn->prepare("SELECT Email FROM Customer WHERE Email = ?");
       $checkEmail->bind_param("s", $email);
       $checkEmail->execute();
       $result = $checkEmail->get_result();
       if ($result->num_rows > 0) {
           throw new Exception("Email already exists");
       }
       $stmt = $conn->prepare("INSERT INTO Customer (fullName, Email, Password, RegistrationDate) VALUES (?, ?, ?, ?)");
       $stmt->bind_param("ssss", $name, $email, $hashedPassword, $registration_date);
       if ($stmt->execute()) {
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
    <?php
    if (!empty($error_message)) {
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    ?>
    <form id="Register-form" method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="confirmPassword" placeholder="Confirm Password" required />
        <input type="submit" name="submit" value="Sign Up" />
    </form>
    <div class="register-link">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</section>

<style>
    #Register-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px; 
        padding: 20px;
        width: 100%;
        max-width: 400px;
        margin: 0 auto; 
    }

    #Register-form input[type="text"],
    #Register-form input[type="email"],
    #Register-form input[type="password"] {
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

    #Register-form input[type="text"]:focus,
    #Register-form input[type="email"]:focus,
    #Register-form input[type="password"]:focus {
        border-color: #0078d7;
        box-shadow: 0 0 8px rgba(0, 120, 215, 0.3);
    }

    #Register-form input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    /* Submit button styles */
    #Register-form input[type="submit"] {
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

    #Register-form input[type="submit"]:hover {
        background-color: #005bb5;
        transform: translateY(-2px);
    }

    #Register-form input[type="submit"]:active {
        transform: translateY(0);
    }

    /* Register link styling */
    .register-link {
        font-size: 14px;
        text-align: center;
        margin-top: 10px;
    }

    .register-link a {
        color: #0078d7;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    /* Section title alignment */
    #sign-up h2 {
        text-align: center;
        margin-bottom: 15px;
    }
</style>

<?php
include 'footer.php';
?>