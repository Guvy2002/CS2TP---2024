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
        $sql = $conn->prepare("SELECT employeeID, Email, Password, position FROM Employee WHERE Email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["Password"])) {
                if ($row["position"] === "admin") {
                    $_SESSION['employeeID'] = $row['employeeID'];
                    $_SESSION['admin'] = true;
                    header("Location: inventory_dashboard.php");
                    exit();
                } else {
                    $error_message = "Unauthorized access. This login is for administrators only.";
                }
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
    <div class="login-container">
        <h2>Admin Login</h2>
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
        <div class="customer-link">
            <p>Not an admin? <a href="login.php">Customer login here</a></p>
        </div>
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

    #login-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    #login-form input[type="email"],
    #login-form input[type="password"] {
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

    #login-form input[type="email"]:focus,
    #login-form input[type="password"]:focus {
        border-color: #0078d7;
        box-shadow: 0 0 8px rgba(0, 120, 215, 0.3);
    }

    #login-form input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    #login-form input[type="submit"] {
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

    #login-form input[type="submit"]:hover {
        background-color: #005bb5;
        transform: translateY(-2px);
    }

    #login-form input[type="submit"]:active {
        transform: translateY(0);
    }

    .error-message {
        color: #dc3545;
        background-color: #f8d7da;
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
</style>

<?php
include 'footer.php';
?>