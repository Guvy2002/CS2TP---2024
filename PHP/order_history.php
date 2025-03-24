<?php
require_once("dbconnection.php");
ob_start();
include 'header.php';

if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['customerID'];

$orderQuery = $conn->prepare("
    SELECT o.*, 
           (SELECT COUNT(*) FROM OrderItem oi WHERE oi.orderID = o.orderID) as itemCount
    FROM Orders o
    WHERE o.customerID = ?
    ORDER BY o.orderDate DESC
");
$orderQuery->bind_param("i", $customerID);
$orderQuery->execute();
$orders = $orderQuery->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<style>
    .history-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .history-header {
        margin-bottom: 30px;
    }
    
    .history-header h1 {
        color: #0078d7;
        margin-bottom: 10px;
    }
    
    .order-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .order-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
    }
    
    .order-id {
        font-weight: bold;
        color: #0078d7;
    }
    
    .order-date {
        color: #666;
        font-size: 14px;
    }
    
    .order-content {
        padding: 20px;
    }
    
    .order-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .detail-group {
        flex: 1;
        min-width: 180px;
    }
    
    .detail-group h3 {
        font-size: 16px;
        margin-bottom: 5px;
        color: #333;
    }
    
    .detail-content {
        color: #666;
        font-size: 14px;
    }
    
    .order-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-shipped {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .status-delivered {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-canceled {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #eee;
    }
    
    .item-count {
        color: #666;
        font-size: 14px;
    }
    
    .order-total {
        font-weight: bold;
        font-size: 16px;
    }
    
    .view-details {
        display: block;
        text-align: center;
        padding: 10px 20px;
        background-color: #0078d7;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        margin-top: 15px;
    }
    
    .view-details:hover {
        background-color: #005bb5;
    }
    
    .empty-orders {
        text-align: center;
        padding: 50px 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .empty-orders h2 {
        color: #333;
        margin-bottom: 15px;
    }
    
    .empty-orders p {
        color: #666;
        margin-bottom: 20px;
    }
    
    .shop-now {
        display: inline-block;
        padding: 12px 24px;
        background-color: #0078d7;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    }
    
    .shop-now:hover {
        background-color: #005bb5;
    }
</style>

<div class="history-container">
    <div class="history-header">
        <h1>Order History</h1>
        <p>View and track all your orders</p>
    </div>
    
    <?php if (empty($orders)): ?>
    <div class="empty-orders">
        <h2>No Orders Yet</h2>
        <p>Looks like you haven't placed any orders with us yet.</p>
        <a href="homepage.php" class="shop-now">Shop Now</a>
    </div>
    <?php else: ?>
    <div class="order-list">
        <?php foreach ($orders as $order): ?>
        <div class="order-card">
            <div class="order-header">
                <div class="order-date"><?php echo date('F j, Y', strtotime($order['orderDate'])); ?></div>
            </div>
            <div class="order-content">
                <div class="order-details">
                    <div class="detail-group">
                        <h3>Status</h3>
                        <div class="detail-content">
                            <span class="order-status status-<?php echo strtolower($order['orderStatus']); ?>">
                                <?php echo htmlspecialchars($order['orderStatus']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="detail-group">
                        <h3>Shipping Address</h3>
                        <div class="detail-content">
                            <?php echo htmlspecialchars($order['ShippingAddress']); ?>
                        </div>
                    </div>
                    <?php if ($order['shippingDate']): ?>
                    <div class="detail-group">
                        <h3>Shipping Date</h3>
                        <div class="detail-content">
                            <?php echo date('F j, Y', strtotime($order['shippingDate'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <a href="order_details.php?id=<?php echo $order['orderID']; ?>" class="view-details">View Order Details</a>
            </div>
            <div class="order-footer">
                <div class="item-count"><?php echo $order['itemCount']; ?> item<?php echo $order['itemCount'] > 1 ? 's' : ''; ?></div>
                <div class="order-total">Total: £<?php echo number_format($order['totalPrice'], 2); ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php 
include 'footer.php'; 
ob_end_flush();
?>