<?php 
include 'header.php';
require_once ('dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    .container {
    background-color: #f8f8f8;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 450px;
    margin: 40px auto;
    text-align: center;
}

.container input,
.container textarea {
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

.container input:focus,
.container textarea:focus {
    border-color: #0078d7;
    box-shadow: 0 0 8px rgba(0, 120, 215, 0.3);
}

.container input::placeholder,
.container textarea::placeholder {
    color: #aaa;
    font-style: italic;
}

.container button {
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

.container button:hover {
    background-color: #005bb5;
    transform: translateY(-2px);
}

.container button:active {
    transform: translateY(0);
}

h1 {
    text-align: center;
    padding-left: 10px;
    font-size: 32px;
    color: #0078d7;
}
  </style>
</head>

<body>
    

<h1>Contact Us</h1>
<div class="container">
    <form action="https://formspree.io/f/xeoellqo" method="POST">
        <input type="email" name="email" placeholder="Your email" required>
        <textarea name="message" placeholder="Your message" required></textarea>
        <button type="submit">Send</button>
    </form>
</div>
</body>
<?php include 'footer.php'?>
