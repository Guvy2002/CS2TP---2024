<?php
require_once("dbconnection.php");
ob_start();
include 'header.php';

if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: order_history.php");
    exit();
}

$orderID = intval($_GET['id']);
$customerID = $_SESSION['customerID'];

$orderQuery = $conn->prepare("
    SELECT o.*, p.paymentMethod 
    FROM Orders o
    LEFT JOIN Payment p ON o.paymentID = p.paymentID
    WHERE o.orderID = ? AND o.customerID = ?
");
$orderQuery->bind_param("ii", $orderID, $customerID);
$orderQuery->execute();
$orderResult = $orderQuery->get_result();

if ($orderResult->num_rows === 0) {
    header("Location: order_history.php");
    exit();
}

$order = $orderResult->fetch_assoc();

$itemsQuery = $conn->prepare("
    SELECT oi.*, p.fullName, p.imgURL
    FROM OrderItem oi
    JOIN Products p ON oi.productID = p.productID
    WHERE oi.orderID = ?
");
$itemsQuery->bind_param("i", $orderID);
$itemsQuery->execute();
$items = $itemsQuery->get_result()->fetch_all(MYSQLI_ASSOC);

$subtotal = 0;
foreach ($items as $item) {
    $subtotal += $item['itemPrice'] * $item['Quantity'];
}

$shipping = $order['totalPrice'] - $subtotal;

$historyQuery = $conn->prepare("
    SELECT * FROM OrderHistory
    WHERE orderID = ?
    ORDER BY ActionDate ASC
");
$historyQuery->bind_param("i", $orderID);
$historyQuery->execute();
$history = $historyQuery->get_result()->fetch_all(MYSQLI_ASSOC);

if (empty($history)) {
    $history[] = [
        'Action' => 'Order Created',
        'ActionDate' => $order['orderDate']
    ];
}


?>

<style>
    .details-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .details-header h1 {
        color: #0078d7;
        margin: 0;
    }
    
    .back-button {
        display: flex;
        align-items: center;
        color: #0078d7;
        text-decoration: none;
        font-weight: bold;
    }
    
    .back-button i {
        margin-right: 5px;
    }
    
    .order-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }
    
    @media (max-width: 768px) {
        .order-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .order-items {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
    }
    
    .order-items h2 {
        margin-top: 0;
        margin-bottom: 20px;
        padding-bottom: 15px;
        
    }
    
    .item-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .order-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .item-image {
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin-right: 15px;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-name {
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .item-price {
        font-size: 14px;
    }
    
    .item-quantity {
        font-size: 14px;
        color: #666;
    }
    
    .item-total {
        font-weight: bold;
        text-align: right;
    }
    
    .order-summary {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .order-info {
        padding: 20px;
    }
    
    .info-section {
        margin-bottom: 20px;
    }
    
    .info-section:last-child {
        margin-bottom: 0;
    }
    
    .info-section h3 {
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }
    
    .info-content {
        color: #666;
        line-height: 1.6;
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
    
    .price-summary {
        padding: 20px;
        background: #f8f9fa;
        border-top: 1px solid #eee;
    }
    
    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .price-row:last-child {
        margin-bottom: 0;
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #ddd;
    }
    
    .order-actions {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .action-button {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        background-color: #0078d7;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    }
    
    .action-button i {
        margin-right: 8px;
    }
    
    .action-button.secondary {
        background-color: white;
        color: #0078d7;
        border: 1px solid #0078d7;
    }
    
    .action-button:hover {
        opacity: 0.9;
    }
    
    .order-history {
        margin-top: 30px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
    }
    
    .order-history h2 {
        margin-top: 0;
        margin-bottom: 20px;
    }
    
    .history-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .history-timeline:before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #ddd;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-point {
        position: absolute;
        left: -30px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #0078d7;
    }
    
    .timeline-date {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }
    
    .timeline-action {
        font-weight: bold;
    }
</style>

<div class="details-container">
    <div class="details-header">
        <h1>Order</h1>
        <a href="order_history.php" class="back-button">
            <i class="bi bi-arrow-left"></i> Back to Order History
        </a>
    </div>
    
    <div class="order-grid">
        <div class="order-items">
            <h2>Order Items</h2>
            <div class="item-list">
                <?php foreach ($items as $item): ?>
                <div class="order-item">
                    <img src="<?php echo htmlspecialchars($item['imgURL']); ?>" alt="<?php echo htmlspecialchars($item['fullName']); ?>" class="item-image">
                    <div class="item-details">
                        <div class="item-name"><?php echo htmlspecialchars($item['fullName']); ?></div>
                        <div class="item-price">£<?php echo number_format($item['itemPrice'], 2); ?></div>
                        <div class="item-quantity">Quantity: <?php echo $item['Quantity']; ?></div>
                    </div>
                    <div class="item-total">
                        £<?php echo number_format($item['itemPrice'] * $item['Quantity'], 2); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="order-summary">
            <div class="order-info">
                <div class="info-section">
                    <h3>Order Status</h3>
                    <div class="info-content">
                        <span class="order-status status-<?php echo strtolower($order['orderStatus']); ?>">
                            <?php echo htmlspecialchars($order['orderStatus']); ?>
                        </span>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3>Order Date</h3>
                    <div class="info-content">
                        <?php echo date('F j, Y', strtotime($order['orderDate'])); ?>
                    </div>
                </div>
                
                <?php if ($order['shippingDate']): ?>
                <div class="info-section">
                    <h3>Shipping Date</h3>
                    <div class="info-content">
                        <?php echo date('F j, Y', strtotime($order['shippingDate'])); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="info-section">
                    <h3>Shipping Address</h3>
                    <div class="info-content">
                        <?php echo nl2br(htmlspecialchars($order['ShippingAddress'])); ?>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3>Payment Method</h3>
                    <div class="info-content">
                        <?php echo htmlspecialchars($order['paymentMethod']); ?>
                    </div>
                </div>
            </div>
            
            <div class="price-summary">
                <div class="price-row">
                    <span>Subtotal:</span>
                    <span>£<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div class="price-row">
                    <span>Shipping:</span>
                    <span><?php echo $shipping > 0 ? '£' . number_format($shipping, 2) : 'FREE'; ?></span>
                </div>
                <div class="total-row">
                    <span>Total:</span>
                    <span>£<?php echo number_format($order['totalPrice'], 2); ?></span>
                </div>
            </div>
            
            <div class="order-actions">
                <?php if ($order['orderStatus'] !== 'Pending' && $order['orderStatus'] !== 'Returned'): ?>
                <a href="returns.php?id=<?php echo $orderID; ?>" class="action-button">
                    <i class="bi bi-chat-dots"></i> Return Items
                </a>
                <?php endif; ?>
                <a href="javascript:window.print();" class="action-button secondary">
                    <i class="bi bi-printer"></i> Print Order
                </a>
            </div>
        </div>
    </div>
    
    <div class="order-history">
        <h2>Order Timeline</h2>
        <div class="history-timeline">
            <?php foreach ($history as $entry): ?>
            <div class="timeline-item">
                <div class="timeline-point"></div>
                <div class="timeline-date"><?php echo date('F j, Y', strtotime($entry['ActionDate'])); ?></div>
                <div class="timeline-action"><?php echo htmlspecialchars($entry['Action']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php 
include 'footer.php'; 
ob_end_flush();
?>