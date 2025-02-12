<?php
require_once('dbconnection.php');

session_start();

$error_message = '';

if (isset($_POST['submit'])) {
    try {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        if (empty($email) || empty($password)) {
            throw new Exception("All fields are required");
        }
        $sql = $conn->prepare("SELECT customerID, Email, Password FROM Customer WHERE Email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["Password"])) {
                $_SESSION['customerID'] = $row['customerID'];
                header("Location: homepage.php");
                exit();
            } else {
                $error_message = "Incorrect password, please try again";
            }
        } else {
            $error_message = "Email not found";
        }
    } catch (Exception $ex) {
        $error_message = "Error: " . $ex->getMessage();
    }
}
include 'header.php';
?>

<section id="sign-in">
    <h2>Login</h2>
    <?php
    if (!empty($error_message)) {
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    ?>
    <form id="login-form" method="POST" action="">
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" name="submit" value="Login" />
    </form>
    <div class="register-link">
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</section>
<style>
    #login-form input[type="email"],
    #login-form input[type="password"],
    #login-form input[type="text"] {
        width: 100%;
        max-width: 400px;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    #login-form input[type="email"]:focus,
    #login-form input[type="password"]:focus,
    #login-form input[type="text"]:focus {
        border-color: #0078d7;
        box-shadow: 0 0 8px rgba(0, 120, 215, 0.3);
    }

    #login-form input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    #login-form input[type="submit"] {
        width: 100%;
        max-width: 400px;
        padding: 12px 15px;
        margin: 10px 0;
        background-color: #0078d7;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    #login-form input[type="submit"]:hover {
        background-color: #005bb5;
        transform: translateY(-2px);
    }

    #login-form input[type="submit"]:active {
        transform: translateY(0);
    }

    #login-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    #sign-in h2 {
        padding-left: 100px;
    }

    .register-link {
        font-size: 14px;
        text-align: center;
        margin: -5px 0 5px 0;
    }

    .register-link a {
        color: #0078d7;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>


<?php
include 'footer.php';
?>