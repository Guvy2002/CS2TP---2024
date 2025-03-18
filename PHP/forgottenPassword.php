<?php 
include = 'header.php';
require_once = 'dbconnection.php';

$error_message = '';
$success_message = '';

if (isset($_POST['submit'])){
	$email = $_POST['email'];
}

?>

<section id="Forgotten Password">
    <div class="forggotenPassword-container">
        <h2>Forgotten Password</h2>
        <?php
        if (!empty($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
        if (!empty($success_message)) {
            echo '<div class="success-message">' . $success_message . '</div>';
        }
        ?>
        <form id="Password-form" method="POST" action="">
            <input type="email" name="email" placeholder="Email Address" required />
        </form>
    </div>
</section>