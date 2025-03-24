<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to GamePoint</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      background-color: #ffffff;
      margin: 20px auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .header {
      background: linear-gradient(180deg, rgb(49, 43, 43), rgb(248, 244, 249));
      padding: 20px;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
    .header img {
      max-width: 150px;
    }
    h1 {
      color: #333;
    }
    p {
      color: #555;
      font-size: 16px;
      line-height: 1.5;
    }
    .button {
      display: inline-block;
      background-color: #007bff;
      color: #ffffff;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 20px;
    }
    .footer {
      margin-top: 20px;
      font-size: 12px;
      color: #888;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
    <img src="cid:logoIMG" class="logo" alt="GamePoint Logo"> 
    </div>
    <h1>Change your GamePoint Password</h1>
    <p>We're excited to have you on board. Get ready to explore, connect, and enjoy everything our platform has to offer.</p>
    <p>Click the button below to change your password:</p>
    <a href="https://cs2team8.cs2410-web01pvm.aston.ac.uk/forgottenpasswordemail.php?id=<?php echo $code; ?>&customerID=<?php echo $customerID; ?>" class="button">Change Password</a>
    <p class="footer">If you are struggling to change your password, feel free to contact our support team @gamepointsite@gmail.com.</p>
  </div>

</body>
</html>