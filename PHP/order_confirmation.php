<?php
require_once("dbconnection.php");
ob_start();

if (isset($_GET['order'])) {
    $orderID = intval($_GET['order']);
    
    if (!isset($_SESSION['email_sent_for_order']) || $_SESSION['email_sent_for_order'] != $orderID) {
        $_SESSION['email_sent_for_order'] = $orderID;
        
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'timeout' => 1 
            )
        );
        $context = stream_context_create($opts);
        @file_get_contents("http://" . $_SERVER['HTTP_HOST'] . "/sendEmail.php?contents=order_confirmation&orderID=" . $orderID, false, $context);
    }
}

include 'header.php';

if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

$orderID = intval($_GET['order']);
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
    header("Location: homepage.php");
    exit();
}

$order = $orderResult->fetch_assoc();

$itemsQuery = $conn->prepare("
    SELECT oi.*, p.fullName, p.Price, p.imgURL
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

$shippingCost = $order['totalPrice'] - $subtotal;
?>

<style>
    .confirmation-container {
        max-width: 900px;
        margin: 60px auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 40px;
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .confirmation-header {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 25px;
        border-bottom: 1px solid #eee;
    }
    
    .confirmation-header h1 {
        color: #0078d7;
        margin-bottom: 15px;
        font-size: 32px;
        font-weight: 700;
    }
    
    .confirmation-header p {
        color: #555;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 10px;
    }
    
    .confirmation-header p:last-child {
        font-size: 18px;
        margin-top: 20px;
    }
    
    .success-icon {
        font-size: 60px;
        color: #28a745;
        margin-bottom: 20px;
        display: inline-block;
        animation: scaleIn 0.5s ease-in-out;
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }
    
    .order-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        flex-wrap: wrap;
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 25px;
    }
    
    .detail-group {
        margin-bottom: 25px;
        flex: 1;
        min-width: 200px;
        padding: 0 15px;
    }
    
    .detail-group h3 {
        color: #333;
        margin-bottom: 12px;
        font-size: 18px;
        font-weight: 600;
        border-bottom: 2px solid #0078d7;
        padding-bottom: 8px;
        display: inline-block;
    }
    
    .detail-content {
        color: #555;
        line-height: 1.8;
        font-size: 15px;
    }
    
    .order-items {
        margin-bottom: 35px;
    }
    
    .order-items h2 {
        color: #333;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 600;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
        transition: transform 0.3s ease;
    }
    
    .order-item:hover {
        transform: translateX(5px);
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-image {
        width: 90px;
        height: 90px;
        object-fit: contain;
        margin-right: 20px;
        background-color: #f9f9f9;
        padding: 5px;
        border-radius: 6px;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-name {
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 16px;
    }
    
    .item-price {
        color: #0078d7;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .item-quantity {
        color: #666;
        font-size: 14px;
    }
    
    .order-summary {
        background: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 16px;
        color: #555;
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #ddd;
        font-size: 20px;
        color: #333;
    }
    
    .action-buttons {
        display: flex;
        justify-content: center;
        margin-top: 40px;
        gap: 20px;
    }
    
    .action-button {
        padding: 15px 30px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .continue-shopping {
        background-color: #0078d7;
        color: white;
        border: none;
    }
    
    .view-orders {
        background-color: white;
        color: #0078d7;
        border: 1px solid #0078d7;
    }
    
    .continue-shopping:hover {
        background-color: #005bb5;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .view-orders:hover {
        background-color: #f0f7ff;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .order-message {
        text-align: center;
        margin: 30px 0;
        padding: 20px;
        background-color: #e8f5e9;
        border-radius: 8px;
        color: #2e7d32;
        font-size: 16px;
        line-height: 1.6;
    }
    
    .order-message p {
        margin-bottom: 0;
    }
    
    @media (max-width: 768px) {
        .confirmation-container {
            padding: 25px;
            margin: 30px 15px;
        }
        
        .detail-group {
            flex: 0 0 100%;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 15px;
        }
        
        .action-button {
            width: 100%;
        }
    }
</style>

<div class="confirmation-container">
    <div class="confirmation-header">
        <div class="success-icon"><i class="bi bi-check-circle-fill"></i></div>
        <h1>Thank You for Your Order!</h1>
        <p>We've received your order and are working on processing it right away.</p>
        <p><strong>Order Number:</strong> #<?php echo $orderID; ?></p>
    </div>
    
    <div class="order-message">
        <p>A confirmation email will be sent to your registered email address shortly.</p>
    </div>
    
    <div class="order-details">
        <div class="detail-group">
            <h3>Shipping Address</h3>
            <div class="detail-content">
                <?php echo htmlspecialchars($order['ShippingAddress']); ?>
            </div>
        </div>
        <div class="detail-group">
            <h3>Payment Method</h3>
            <div class="detail-content">
                <?php echo htmlspecialchars($order['paymentMethod']); ?>
            </div>
        </div>
        <div class="detail-group">
            <h3>Order Date</h3>
            <div class="detail-content">
                <?php echo date('F j, Y', strtotime($order['orderDate'])); ?>
            </div>
        </div>
        <div class="detail-group">
            <h3>Order Status</h3>
            <div class="detail-content">
                <span style="color: #28a745; font-weight: 600;"><?php echo htmlspecialchars($order['orderStatus']); ?></span>
            </div>
        </div>
    </div>
    
    <h2>Order Items</h2>
    <div class="order-items">
        <?php foreach ($items as $item): ?>
        <div class="order-item">
            <img src="<?php echo htmlspecialchars($item['imgURL']); ?>" alt="<?php echo htmlspecialchars($item['fullName']); ?>" class="item-image">
            <div class="item-details">
                <div class="item-name"><?php echo htmlspecialchars($item['fullName']); ?></div>
                <div class="item-price">£<?php echo number_format($item['itemPrice'], 2); ?></div>
                <div class="item-quantity">Quantity: <?php echo $item['Quantity']; ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="order-summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>£<?php echo number_format($subtotal, 2); ?></span>
        </div>
        <div class="summary-row">
            <span>Shipping:</span>
            <span><?php echo $shippingCost > 0 ? '£' . number_format($shippingCost, 2) : 'FREE'; ?></span>
        </div>
        <div class="total-row">
            <span>Total:</span>
            <span>£<?php echo number_format($order['totalPrice'], 2); ?></span>
        </div>
    </div>
    
    <div class="action-buttons">
        <a href="homepage.php" class="action-button continue-shopping">Continue Shopping</a>
        <a href="order_history.php" class="action-button view-orders">View My Orders</a>
    </div>
</div>

<script>
   
    function printOrder() {
        window.print();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const actionButtons = document.querySelector('.action-buttons');
        
        const printButton = document.createElement('a');
        printButton.className = 'action-button view-orders';
        printButton.innerHTML = '<i class="bi bi-printer"></i> Print Order';
        printButton.href = 'javascript:void(0)';
        printButton.onclick = printOrder;
        
        actionButtons.appendChild(printButton);
    });
</script>

<?php include 'footer.php'; ?>