<?php 
$host = 'localhost:3306';
$username = 'cs2team8';
$password = 'ZAUzatiI5V99EcF';
$database='cs2team8_db';
$conn = new mysqli($host ,$username ,$password ,$database); 
if ($conn->connect_error) { 
   die("Connection failure: " . $conn->connect_error);
}                 
?>
 