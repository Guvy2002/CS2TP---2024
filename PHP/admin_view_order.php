<?php
session_start();
require_once("dbconnection.php");
ob_start();
include 'header.php';

//security check for admin
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_orders.php");
    exit();
}

$orderID = intval($_GET['id']);


$orderQuery = $conn->prepare("
    SELECT o.*, c.fullName, c.Email, p.paymentMethod
    FROM Orders o
    JOIN Customer c ON o.customerID = c.customerID
    LEFT JOIN Payment p ON o.paymentID = p.paymentID
    WHERE o.orderID = ?
");
$orderQuery->bind_param("i", $orderID);
$orderQuery->execute();
$orderResult = $orderQuery->get_result();

if ($orderResult->num_rows === 0) {
    header("Location: admin_orders.php");
    exit();
}

$order = $orderResult->fetch_assoc();


if (isset($_POST['update_status'])) {
    $newStatus = $_POST['order_status'];
    $shippingDate = null;
    
    
    if ($newStatus === 'Shipped') {
        $shippingDate = date('Y-m-d');
    }
    
    $updateOrder = $conn->prepare("UPDATE Orders SET orderStatus = ?, shippingDate = ? WHERE orderID = ?");
    $updateOrder->bind_param("ssi", $newStatus, $shippingDate, $orderID);
    
    if ($updateOrder->execute()) {
        $action = "Status updated to " . $newStatus;
        $currentDate = date('Y-m-d');
        
        $historyInsert = $conn->prepare("INSERT INTO OrderHistory (customerID, orderID, Action, ActionDate) VALUES (?, ?, ?, ?)");
        $historyInsert->bind_param("iiss", $order['customerID'], $orderID, $action, $currentDate);
        $historyInsert->execute();
        
        $updateSuccess = "Order status has been updated to $newStatus.";
        
        $orderQuery->execute();
        $order = $orderQuery->get_result()->fetch_assoc();
    } else {
        $updateError = "Error updating order status: " . $conn->error;
    }
}

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

<div class="admin-container">
    <div class="order-header">
        <h1>Order #<?php echo $orderID; ?> Details</h1>
        <div class="header-actions">
            <a href="admin_orders.php" class="back-link"><i class="bi bi-arrow-left"></i> Back to Orders</a>
            <button class="status-btn" onclick="document.getElementById('statusModal').style.display='block'">
                <i class="bi bi-pencil-square"></i> Update Status
            </button>
        </div>
    </div>
    
    <?php if (isset($updateSuccess)): ?>
        <div class="alert alert-success"><?php echo $updateSuccess; ?></div>
    <?php endif; ?>
    
    <?php if (isset($updateError)): ?>
        <div class="alert alert-danger"><?php echo $updateError; ?></div>
    <?php endif; ?>
    
    <div class="order-status-banner status-<?php echo strtolower($order['orderStatus']); ?>">
        <div class="status-icon">
            <?php
            $statusIcon = '';
            switch (strtolower($order['orderStatus'])) {
                case 'pending':
                    $statusIcon = 'hourglass-split';
                    break;
                case 'processing':
                    $statusIcon = 'gear';
                    break;
                case 'shipped':
                    $statusIcon = 'truck';
                    break;
                case 'delivered':
                    $statusIcon = 'check-circle';
                    break;
                case 'cancelled':
                    $statusIcon = 'x-circle';
                    break;
                default:
                    $statusIcon = 'circle';
            }
            ?>
            <i class="bi bi-<?php echo $statusIcon; ?>"></i>
        </div>
        <div class="status-info">
            <h2><?php echo $order['orderStatus']; ?></h2>
            <p>
                <?php
                switch (strtolower($order['orderStatus'])) {
                    case 'pending':
                        echo "Order is awaiting processing";
                        break;
                    case 'processing':
                        echo "Order is being prepared";
                        break;
                    case 'shipped':
                        echo "Order was shipped on " . date('F j, Y', strtotime($order['shippingDate']));
                        break;
                    case 'delivered':
                        echo "Order was delivered";
                        break;
                    case 'cancelled':
                        echo "Order has been cancelled";
                        break;
                    default:
                        echo "Order status: " . $order['orderStatus'];
                }
                ?>
            </p>
        </div>
    </div>
    
    <div class="order-grid">
        <div class="order-details-section">
            <div class="order-details-card">
                <h3>Order Information</h3>
                <div class="info-row">
                    <div class="info-label">Order Date:</div>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($order['orderDate'])); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Order Status:</div>
                    <div class="info-value">
                        <span class="status-badge status-<?php echo strtolower($order['orderStatus']); ?>">
                            <?php echo $order['orderStatus']; ?>
                        </span>
                    </div>
                </div>
                <?php if ($order['shippingDate']): ?>
                <div class="info-row">
                    <div class="info-label">Shipping Date:</div>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($order['shippingDate'])); ?></div>
                </div>
                <?php endif; ?>
                <div class="info-row">
                    <div class="info-label">Payment Method:</div>
                    <div class="info-value"><?php echo $order['paymentMethod'] ?? 'Not specified'; ?></div>
                </div>
            </div>
            
            <div class="order-details-card">
                <h3>Customer Information</h3>
                <div class="info-row">
                    <div class="info-label">Customer:</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['fullName']); ?> (ID: <?php echo $order['customerID']; ?>)</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['Email']); ?></div>
                </div>
                <div class="customer-actions">
                    <a href="customer_management.php?search=<?php echo urlencode($order['customerID']); ?>" class="view-customer-btn">
                        <i class="bi bi-person"></i> View Customer
                    </a>
                    <a href="admin_orders.php?customer=<?php echo $order['customerID']; ?>" class="customer-orders-btn">
                        <i class="bi bi-bag"></i> Customer Orders
                    </a>
                </div>
            </div>
            
            <div class="order-details-card">
                <h3>Shipping Address</h3>
                <div class="address">
                    <?php echo nl2br(htmlspecialchars($order['ShippingAddress'])); ?>
                </div>
            </div>
            
            <div class="order-details-card">
                <h3>Order Timeline</h3>
                <div class="timeline">
                    <?php foreach ($history as $entry): ?>
                    <div class="timeline-item">
                        <div class="timeline-date">
                            <?php echo date('M j, Y', strtotime($entry['ActionDate'])); ?>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-dot"></div>
                            <div class="timeline-text">
                                <?php echo htmlspecialchars($entry['Action']); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="order-items-section">
            <div class="order-details-card">
                <h3>Order Items</h3>
                <div class="order-items">
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
                
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>£<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span><?php echo $shipping > 0 ? '£' . number_format($shipping, 2) : 'FREE'; ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>£<?php echo number_format($order['totalPrice'], 2); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="order-details-card">
                <h3>Admin Actions</h3>
                <div class="admin-actions-list">
                    <button class="admin-action-btn" onclick="document.getElementById('statusModal').style.display='block'">
                        <i class="bi bi-pencil-square"></i> Update Order Status
                    </button>
                    <a href="javascript:window.print();" class="admin-action-btn">
                        <i class="bi bi-printer"></i> Print Order Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="statusModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('statusModal').style.display='none'">&times;</span>
        <h2>Update Order Status</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="order_status">Status:</label>
                <select id="order_status" name="order_status" required>
                    <option value="Pending" <?php echo $order['orderStatus'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Processing" <?php echo $order['orderStatus'] === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                    <option value="Shipped" <?php echo $order['orderStatus'] === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                    <option value="Delivered" <?php echo $order['orderStatus'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                	<option value="Returned" <?php echo $order['orderStatus'] === 'Returned' ? 'selected' : ''; ?>>Returned</option>
                    <option value="Cancelled" <?php echo $order['orderStatus'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <div class="status-note">
                <p><strong>Note:</strong> Changing status to 'Shipped' will automatically set todays date as the shipping date.</p>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="document.getElementById('statusModal').style.display='none'">Cancel</button>
                <button type="submit" name="update_status" class="save-btn">Update Status</button>
            </div>
        </form>
    </div>
</div>

<style>

.admin-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.order-header h1 {
    color: #0078d7;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 15px;
}

.back-link {
    color: #0078d7;
    text-decoration: none;
    font-weight: bold;
    display: flex;
    align-items: center;
}

.back-link i {
    margin-right: 5px;
}

.status-btn {
    background-color: #0078d7;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    display: flex;
    align-items: center;
}

.status-btn i {
    margin-right: 5px;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.order-status-banner {
    display: flex;
    align-items: center;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.status-pending {
    background-color: #fff3cd;
    color: #856404;
}

.status-processing {
    background-color: #cce5ff;
    color: #004085;
}

.status-shipped {
    background-color: #d1ecf1;
    color: #0c5460;
}

.status-delivered {
    background-color: #d4edda;
    color: #155724;
}

.status-cancelled {
    background-color: #f8d7da;
    color: #721c24;
}

.status-icon {
    font-size: 36px;
    margin-right: 20px;
}

.status-info h2 {
    margin: 0 0 5px 0;
    font-size: 24px;
}

.status-info p {
    margin: 0;
    font-size: 14px;
}

.order-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 1000px) {
    .order-grid {
        grid-template-columns: 1fr;
    }
}

.order-details-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    padding: 20px;
}

.order-details-card h3 {
    margin-top: 0;
    margin-bottom: 15px;
    color: #333;
    font-size: 18px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}


.info-row {
    display: flex;
    margin-bottom: 10px;
}

.info-label {
    font-weight: bold;
    width: 120px;
    color: #555;
}

.info-value {
    flex: 1;
}

.address {
    line-height: 1.6;
    white-space: pre-line;
}

.status-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.customer-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.view-customer-btn,
.customer-orders-btn {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 4px;
    text-decoration: none;
    background-color: #f8f9fa;
    color: #333;
    border: 1px solid #ddd;
}

.view-customer-btn i,
.customer-orders-btn i {
    margin-right: 5px;
}

.order-items {
    margin-bottom: 20px;
}

.order-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.order-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 70px;
    height: 70px;
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

.item-price,
.item-quantity {
    font-size: 14px;
    color: #666;
}

.item-total {
    font-weight: bold;
    margin-left: 15px;
}

.order-summary {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}

.summary-row.total {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #eee;
    font-weight: bold;
    font-size: 18px;
}

.timeline {
    position: relative;
    margin-left: 20px;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 2px;
    background-color: #eee;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-date {
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
}

.timeline-content {
    display: flex;
    align-items: flex-start;
}

.timeline-dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background-color: #0078d7;
    margin-right: 10px;
    margin-left: -7px;
    z-index: 1;
}

.timeline-text {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    flex: 1;
}

.admin-actions-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.admin-action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    background-color: #f8f9fa;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
    font-size: 14px;
}

.admin-action-btn i {
    margin-right: 8px;
}

.admin-action-btn:hover {
    background-color: #e9ecef;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.modal h2 {
    margin-top: 0;
    color: #333;
}

.status-note {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    margin: 15px 0;
    font-size: 14px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.cancel-btn {
    background-color: #f8f9fa;
    color: #333;
    border: 1px solid #ddd;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
}

.save-btn {
    background-color: #0078d7;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}

@media print {
    .admin-container {
        padding: 0;
    }
    
    .header-actions, 
    .admin-actions-list, 
    .customer-actions {
        display: none;
    }
    
    .order-grid {
        grid-template-columns: 1fr;
    }
    
    .order-details-card {
        box-shadow: none;
        border: 1px solid #ddd;
        break-inside: avoid;
    }
}
</style>

<?php include 'footer.php'; ?>