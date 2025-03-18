<?php
require_once("dbconnection.php");
session_start();

if (isset($_POST['submit'])) {
   $name = trim($_POST['name']);
   $email = trim($_POST['email']);
   $password = $_POST['password'];
   $confirm_password = $_POST['confirmPassword'];
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
                  	   $_SESSION['customerID'] = $row['customerID'];
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
#sign-up {
    background-color: var(--card-bg);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px var(--card-shadow);
    width: 90%;
    max-width: 450px;
    margin: 40px auto;
    text-align: center;
}

#Register-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

#Register-form input[type="text"],
#Register-form input[type="email"],
#Register-form input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin: 5px 0;
    border: 1px solid var(--card-border);
    border-radius: 6px;
    font-size: 16px;
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    background-color: var(--background-color);
    color: var(--text-color);
}

#Register-form input[type="text"]:focus,
#Register-form input[type="email"]:focus,
#Register-form input[type="password"]:focus {
    border-color: var(--heading-color);
    box-shadow: 0 0 8px rgba(var(--heading-color), 0.3);
}

#Register-form input::placeholder {
    color: var(--text-color);
    opacity: 0.5;
    font-style: italic;
}

#Register-form input[type="submit"] {
    width: 100%;
    padding: 12px 15px;
    margin-top: 10px;
    background-color: var(--heading-color);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

#Register-form input[type="submit"]:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

#Register-form input[type="submit"]:active {
    transform: translateY(0);
}

.register-link {
    font-size: 14px;
    text-align: center;
    margin-top: 10px;
    color: var(--text-color);
}

.register-link a {
    color: var(--heading-color);
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline;
}

#sign-up h2 {
    text-align: center;
    padding-left: 95px;
    color: var(--heading-color);
}

.error-message {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 14px;
    text-align: left;
}
</style>
<?php
include 'footer.php';
?>
