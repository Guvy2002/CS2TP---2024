<?php
require_once("dbconnection.php");
ob_start();
include 'header.php';

if (!isset($_SESSION['customerID'])) {
   header("Location: login.php");
   exit();
}

$customerID = $_SESSION['customerID'];
$stmt = $conn->prepare("SELECT fullName, Email FROM Customer WHERE customerID = ?");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<div class="account-container">
   <h1>My Account</h1>
   
   <div class="account-sections">
       <div class="account-box">
           <h2>Account Details</h2>
           <p>Name: <?php echo htmlspecialchars($user['fullName'] ?? ''); ?></p>
           <p>Email: <?php echo htmlspecialchars($user['Email'] ?? ''); ?></p>
           <a href="edit_profile.php" class="account-btn">Edit Profile</a>
           <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
           <a href="admin_dashboard.php" class="account-btn admin-btn">
               <i class="bi bi-shield-lock"></i> Admin Controls
           </a>
           <?php endif; ?>
       </div>

       <div class="account-box">
           <h2>Orders</h2>
           <a href="order_history.php" class="account-btn">View Order History</a>
           <a href="return_history.php" class="account-btn">View Return History</a>
       </div>

       <div class="account-box">
           <h2>Settings</h2>
           <a href="changePassword.php" class="account-btn">Change Password</a>
           <a href="logout.php" class="account-btn logout">Logout</a>
       </div>
   </div>
</div>

<style>
html, body {
   margin: 0;
   padding: 0;
   height: 100%; 
   flex-direction: column; 
}

.account-container {
   max-width: 1200px;
   margin: 40px auto;
   padding: 0 20px;
   flex-grow: 1;
}

.account-container h1 {
   text-align: center;
   color: #0078d7;
   margin-bottom: 30px;
   font-size: 32px;
}

.account-sections {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
   gap: 20px;
   margin-top: 30px;
}

.account-box {
   background-color: white;
   padding: 25px;
   border-radius: 10px;
   box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
   transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.account-box:hover {
   transform: translateY(-5px);
   box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.account-box h2 {
   color: #333;
   margin-bottom: 15px;
   font-size: 20px;
   text-align: center;
}

.account-box p {
   margin-bottom: 10px;
   color: #555;
   font-size: 16px;
}

.account-btn {
   display: block;
   background-color: #0078d7;
   color: white;
   padding: 12px 20px;
   border-radius: 5px;
   text-decoration: none;
   margin-top: 15px;
   text-align: center;
   transition: background-color 0.3s ease, transform 0.2s ease;
}

.account-btn:hover {
   background-color: #0067be;
   transform: translateY(-2px);
}

.admin-btn {
   background-color: #343a40;
   display: flex;
   align-items: center;
   justify-content: center;
   gap: 8px;
}

.admin-btn:hover {
   background-color: #23272b;
}

.logout {
   background-color: #dc3545;
}

.logout:hover {
   background-color: #c82333;
}

.footer-container {
   margin-top: auto;
   padding-bottom: 0;
}

.back-to-top-container {
   margin-top: auto;
   padding-bottom: 0;
}

@media (max-width: 768px) {
   .account-sections {
      grid-template-columns: 1fr;
   }
   
   .account-box {
      margin-bottom: 15px;
   }

   .account-container h1 {
      font-size: 28px;
   }
}
</style>

<?php 
include 'footer.php';
ob_end_flush();
?>