<?php 
include 'header.php';
require_once ('dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    .container {
      max-width: 500px;
      margin: 20px auto;
      padding: 20px;
      background-color: #f4f4f4;
      border-radius: 8px;
    }

    .container label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }

    .container input,
    .container textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .container button {
      display: block;
      width: 150px;
      margin: 10px auto 0;
      padding: 10px 20px;
      background-color: white;
      color: black;
      font-size: 16px;
      font-weight: bold;
      border: 2px solid black;
      border-radius: 5px;
      cursor: pointer;
      text-align: center;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .container button:hover {
      background-color: black;
      color: white;
    }
  </style>
</head>

<body>
    
<!-- Main Content -->
<h1>Contact Us</h1>
<div class="container">
    <form
            action="https://formspree.io/f/xeoellqo"
            method="POST"
    >
        <label>
            Your email:
            <input type="email" name="email">
        </label>
        <label>
            Your message:
            <textarea name="message"></textarea>
        </label>
        <button type="submit">Send</button>
    </form>
</div>
</body>
<?php include 'footer.php'?>