<?php
require_once('DBconnection.php');

if (isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];
    $hashed_Confirm_Password = password_hash($confirm_password, PASSWORD_DEFAULT);
    $registration_date = date("d-m-Y");

    try{
        if ($hashedPassword != $hashed_Confirm_Password) {
            throw new Exception("Passwords do not match");
        }
        if (strlen($hashedPassword) < 7) {
            throw new Exception("Password needs to be at least 8 characters long");
        }
        //$stat = $conn->prepare("INSERT INTO RegisteredCustomer (Name, Email, Password, RegistrationDate) VALUES (?, ?, ?, ?)");
        //$stat->execute([$name, $email, $hashedPassword, $registration_date]);
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="HTML/CSS/HomePage.css">
<head>

    <head>
        <link rel="stylesheet" href="HTML/CSS/HomePage.css">
        <!-- <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css"> -->
    </head>

<body>

<div class="grad3">
    <img src="Images/GamePointLogo.png" class="logo" alt="GamePoint Logo">
    <h2>GamePoint</h2>
</div>

<style>
    .grad3 {
        height: 100px;
        background-color: red;
        /* For browsers that do not support gradients */
        background-image: linear-gradient(180deg, rgb(49, 43, 43), rgb(248, 244, 249));
    }
</style>


<!-- Navigation Bar  -->
<div class="navbar">
    <!-- Left Section: Navigation Links -->
    <ul>
        <li><a href="HTML/Home Page.html">Home</a></li>
        <li><a href="HTML/ps5.html">PlayStation</a></li>
        <li><a href="HTML/XBOX Product Page.html">XBOX</a></li>
        <li><a href="HTML/VR.html">VR</a></li>
        <li><a href="HTML/PC Product Page.html">PC</a></li>
        <li><a href="HTML/sb.html">Special Bundle</a></li>
        <li><a href="HTML/preorder.html">Preorder</a></li>
    </ul>


    <!-- Right Section: Sign In and Basket -->
    <div class="right-section">
        <div class="search-box">
            <input type="text" placeholder="Search...">
        </div>
        <a href="signup.php">Sign up</a>
        <a href="login.php">Login</a>
        <a href="HTML/wishlist.html"><i class="fa-regular fa-heart"></i></a>
        <a href="HTML/basket.html"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</div>


<meta charset="UTF-8" />
<link rel="stylesheet" href="HTML/CSS/HomePage.css" />
<script defer src="JS/script.js"></script>
</head>
</body>
<header id="main-header">
</header>
<section id="sign-up">
    <h2>Register</h2>
    <form id="login-form" class="form-login">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>

        <button class="login-button" type="submit">Login</button>
    </form>
    <div class="register-user">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</section>



<!-- FOOTER -->
<style>
    .footer {
        height: 200px;
        background-color: red;
        /* For browsers that do not support gradients */
        background-image: linear-gradient(180deg, rgb(249, 244, 244), rgb(50, 50, 50));
    }
</style>
<!-- Section: Links -->
<section class="footer">
    <!-- Section: Form -->
    <section class="">
        <form action="">
            <!--Grid row-->
            <div class="row d-flex justify-content-center">
                <!--Grid column-->
                <div class="col-auto">
                    <p class="pt-2">
                        <strong>Sign up to our newsletter by entering your email address</strong>
                    </p>
                </div>
                <div class="col-md-5 col-12">
                    <!-- Email input -->
                    <div class="form-outline form-white mb-4">
                        <input type="email" id="form5Example21" class="form-control" />
                        <label class="form-label" for="form5Example21">            <button type="submit" class="btn btn-outline-light mb-4">
                                Subscribe
                            </button></label>
                    </div>
                    <!--Grid column-->
                </div>
        </form>
    </section>
    <!-- Section: Form -->

    <!-- Section: Text -->
    <div class="mb-4">
        <p>
            Thank you for visiting our website ! Please checkout our products and get the most exclusive and trending
            games at the best and most affordable prices !

        </p>


        <!-- Social Media Section -->
        <div class="social-media">
            <h5>Follow Us on Social Media</h5>
            <div class="social-icons">
                <a href="https://www.instagram.com" target="_blank">
                    <img src="Images/insta logo.webp" alt="Instagram" class="social-icon">
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <img src="Images/twitter logo.png" alt="Twitter" class="social-icon">
                </a>
                <a href="https://www.facebook.com" target="_blank">
                    <img src="Images/facebook logo.png" alt="Facebook" class="social-icon">
                </a>
                <a href="https://www.tiktok.com" target="_blank">
                    <img src="Images/tiktok logo.webp" alt="TikTok" class="social-icon">
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="copyright" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Copyright:
            <a class="text-white" href="#">GamePoint</a>
        </div>
        <!-- Copyright -->
    </div>
</section>
</html>