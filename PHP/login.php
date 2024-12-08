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
    <form id="login-form" method="POST" action="">
      <input type="email" name="email" placeholder="Email" required/>
      <input type="password" name="password" placeholder="Password" required/>
      <input type="submit" name="submit" value="Login"/>
    </form>
  </section>

<?php 

if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = mysqli_connect("localhost", "cs2team8", "ZAUzatil5V99EcF", "cs2team8_db");

    if(!$conn){
        die("Database Failed to Connect: " . mysqli_connect_error());
    }

    try{
        // will replace with actual table names
        
        $sql = $conn->prepare("SELECT email, password FROM users WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0){
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
        $customerIDs = "SELECT Email, customerID FROM RegisteredCustomer";
        $customerIDsResult = $conn->query($customerIDs);
        if ($customerIDsResult->num_rows > 0) {
          while ($row = $customerIDsResult->fetch_assoc()) {
            if ($row['Email'] == $email) {
              $customerID = $row['customerID'];
              echo "<script type=\"text/javascript\">
              document.cookie = 'customerID=" . $customerID . ";path=/';
              </script>";
    
            }
          }
        }

    } catch (exception $ex){
        echo "Error: " . $ex->getMessage();
    } mysqli_close($conn);

}

?>
</body>
</html>
