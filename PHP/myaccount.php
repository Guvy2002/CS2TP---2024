<?php
session_start();
if (!isset($_SESSION['customerID'])) {
   header("Location: login.php");
   exit();
}
require_once("dbconnection.php");
include 'header.php';

// Fetch user details
$customerID = $_SESSION['customerID'];
$stmt = $conn->prepare("SELECT * FROM Customer WHERE customerID = ?");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<div class="account-container">
   <h1>My Account</h1>
   
   <div class="account-sections">
       <div class="account-box">
           <h2>Account Details</h2>
           <p>Name: <?php echo htmlspecialchars($user['fullName']); ?></p>
           <p>Email: <?php echo htmlspecialchars($user['Email']); ?></p>
           <a href="edit_profile.php" class="account-btn">Edit Profile</a>
       </div>

       <div class="account-box">
           <h2>Orders</h2>
           <a href="order_history.php" class="account-btn">View Order History</a>
       </div>

       <div class="account-box">
           <h2>Settings</h2>
           <a href="change_password.php" class="account-btn">Change Password</a>
           <a href="logout.php" class="account-btn logout">Logout</a>
       </div>
   </div>
</div>

<style>
.account-container {
   max-width: 1200px;
   margin: 40px auto;
   padding: 0 20px;
}

.account-sections {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
   gap: 20px;
   margin-top: 30px;
}

.account-box {
   background: white;
   padding: 25px;
   border-radius: 10px;
   box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.account-btn {
   display: block;
   background: #0078d7;
   color: white;
   padding: 12px 20px;
   border-radius: 5px;
   text-decoration: none;
   margin-top: 15px;
   text-align: center;
}

.logout {
   background: #dc3545;
}

.account-btn:hover {
   opacity: 0.9;
}
</style>

<?php include 'footer.php'; ?>