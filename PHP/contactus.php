<?php 
ob_start();
include 'header.php';
require_once ('dbconnection.php');


if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    $_SESSION['submitted'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['message'] = $message;
    
    header("Location: sendEmail.php?contents=responseemail&email=" . urlencode($email) . "&redirect=" . urlencode("/contactus.php?formspree=true"));
    exit();
}

if (isset($_GET['formspree']) && $_GET['formspree'] == 'true' && isset($_SESSION['submitted']) && $_SESSION['submitted']) {
    $email = $_SESSION['email'];
    $message = $_SESSION['message'];
    $_SESSION['submitted'] = false;
    unset($_SESSION['email']);
    unset($_SESSION['message']);
    
    echo '
    <form id="formspreeForm" action="https://formspree.io/f/xeoellqo" method="POST" style="display:none;">
        <input type="email" name="email" value="'.htmlspecialchars($email).'">
        <textarea name="message">'.htmlspecialchars($message).'</textarea>
    </form>
    <script>
        // Submit the form to Formspree
        document.getElementById("formspreeForm").submit();
    </script>
    ';
    
    echo '<div class="success-message" style="color: green; padding: 10px; margin: 10px 0; background-color: #e8f5e9; border-radius: 5px;">Thank you for your message! Your form has been submitted.</div>';
}
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
    <form method="POST" action="">
        <input type="email" id="email" name="email" placeholder="Your email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
        <textarea name="message" placeholder="Your message" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
        <button type="submit" name="submit">Send</button>
    </form>
</div>
</body>
  
<?php 
include 'footer.php';
ob_end_flush();
?>