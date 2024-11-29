?php

if (isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    try{

        need database for this bit
    }
    catch (PDOexception $ex){
        echo "Database error, Please Try Again. <br>";
        echo "Error in details: <em>". $ex->getMessage(),"</em>"
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>GamePoint | Sign Up</title>
    <link rel="icon" href="images/favicon1.ico" type="image/x-icon" />
    <link rel="stylesheet" href="styles.css" />
    <script defer src="script.js"></script>
</head>
<body>
<header id="main-header">
    <div class="logo">
        <img src="images/favicon1.ico" alt="GamePoint Logo" class="logo-img">
        GamePoint
    </div>
</header>
<section id="sign-up">
    <h2>Create Your Account</h2>
    <form id="signup-form">
        <input type="text" name="name" placeholder="First Name" id="name" required />
        <input type="email" name="email" placeholder="Email" id="email" required />
        <input type="password" name="password" placeholder="Password id="password" pattern=".{8,}" title="Password must be at least 8 characters long" required/>
        <input type="password" name="confirm_password" placeholder="Confirm Password"id="confirm_password" pattern=".{8,}" required/>
        <input type="submit" value="Sign Up" />
    </form>
</section>
</body>
</html>
