<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>GamePoint | Login</title>
  <link rel="icon" href="images/favicon1.ico" type="image/x-icon" />
  <link rel="stylesheet" href="ps5styles.css" />
  <script defer src="script.js"></script>
</head>
<body>
  <header id="main-header">
    <div class="logo">
        <img src="images/favicon1.ico" alt="GamePoint Logo" class="logo-img">
        GamePoint
      </div>
  </header>
  <section id="sign-in">
    <h2>Login</h2>
    <form id="login-form">
      <input type="email" name="email" placeholder="Email" required/>
      <input type="password" name="password" placeholder="Password" required/>
      <input type="submit" value="Login"/>
    </form>
  </section>

<?php 

if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once("DBconnection.php");

    try{
        // will replace with actual table names
        
        $sql = $conn->prepare("SELECT email, password FROM users WHERE email = ___");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_of_rows > 0){
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])){
                header("Location: Home Page.html");
                exit();
            } else{
                echo "password incorrect, try again";
            }
        } else{
            echo "email not found";
        }
        $sql->close();

    }
    catch (exception $ex){
        echo "Error: " . $ex->getMessage();
    }

}

?>
</body>
</html>
