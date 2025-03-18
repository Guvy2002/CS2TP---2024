<?php
session_start();
require_once("dbconnection.php");

//security check for admin
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

$_GET['page'] = 'dashboard';

$totalProductsQuery = $conn->query("SELECT COUNT(*) as count FROM Products");
$totalProducts = $totalProductsQuery->fetch_assoc()['count'];

$lowStockQuery = $conn->query("SELECT COUNT(*) as count FROM Products WHERE stockQuantity < 10 AND stockQuantity > 0");
$lowStock = $lowStockQuery->fetch_assoc()['count'];

$outOfStockQuery = $conn->query("SELECT COUNT(*) as count FROM Products WHERE stockQuantity = 0");
$outOfStock = $outOfStockQuery->fetch_assoc()['count'];

$totalCustomersQuery = $conn->query("SELECT COUNT(*) as count FROM Customer");
$totalCustomers = $totalCustomersQuery->fetch_assoc()['count'];

$totalOrdersQuery = $conn->query("SELECT COUNT(*) as count FROM Orders");
$totalOrders = $totalOrdersQuery->fetch_assoc()['count'];

$pendingOrdersQuery = $conn->query("SELECT COUNT(*) as count FROM Orders WHERE orderStatus = 'Pending'");
$pendingOrders = $pendingOrdersQuery->fetch_assoc()['count'];

$totalRevenueQuery = $conn->query("SELECT SUM(totalPrice) as total FROM Orders");
$totalRevenue = $totalRevenueQuery->fetch_assoc()['total'] ?? 0;

$recentProductsQuery = $conn->query("SELECT productID, fullName, Price, stockQuantity FROM Products ORDER BY productID DESC LIMIT 5");
$recentProducts = $recentProductsQuery->fetch_all(MYSQLI_ASSOC);

$recentOrdersQuery = $conn->query("
    SELECT o.orderID, o.orderDate, o.totalPrice, o.orderStatus, c.fullName 
    FROM Orders o
    JOIN Customer c ON o.customerID = c.customerID
    ORDER BY o.orderDate DESC LIMIT 5
");
$recentOrders = $recentOrdersQuery->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - GamePoint</title>
    <link rel="stylesheet" href="ps5styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --primary-color: #0078d7;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --danger-color: #dc3545;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --transition-speed: 0.3s;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin-left var(--transition-speed) ease;
        }

        .admin-container.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        .dashboard-title {
            margin-bottom: 20px;
            color: var(--dark-color);
            font-size: 24px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-right: 15px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .products-icon {
            color: var(--primary-color);
            background-color: rgba(0, 120, 215, 0.1);
        }

        .low-stock-icon {
            color: var(--warning-color);
            background-color: rgba(255, 193, 7, 0.1);
        }

        .out-stock-icon {
            color: var(--danger-color);
            background-color: rgba(220, 53, 69, 0.1);
        }

        .customers-icon {
            color: var(--success-color);
            background-color: rgba(40, 167, 69, 0.1);
        }

        .orders-icon {
            color: #6f42c1;
            background-color: rgba(111, 66, 193, 0.1);
        }

        .pending-icon {
            color: #fd7e14;
            background-color: rgba(253, 126, 20, 0.1);
        }

        .revenue-icon {
            color: #20c997;
            background-color: rgba(32, 201, 151, 0.1);
        }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--dark-color);
            margin: 0;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .table-header {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
        }

        .table-title {
            margin: 0;
            color: var(--dark-color);
            font-size: 18px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th,
        .admin-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .admin-table th {
            font-weight: 600;
            color: #495057;
        }

        .admin-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .stock-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stock-ok {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .stock-low {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .stock-out {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .badge-shipped {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .badge-delivered {
            background-color: rgba(32, 201, 151, 0.1);
            color: #20c997;
        }

        .badge-cancelled {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container" id="adminContainer">
        <?php include 'admin_sidebar.php'; ?>
        
        <main class="main-content">
            <h1 class="dashboard-title">Admin Dashboard</h1>

            <!-- Stats Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon products-icon">
                        <i class="bi bi-box"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-value"><?php echo $totalProducts; ?></p>
                        <p class="stat-label">Total Products</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon low-stock-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-value"><?php echo $lowStock; ?></p>
                        <p class="stat-label">Low Stock Items</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon out-stock-icon">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-value"><?php echo $outOfStock; ?></p>
                        <p class="stat-label">Out of Stock</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon customers-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-value"><?php echo $totalCustomers; ?></p>
                        <p class="stat-label">Total Customers</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orders-icon">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-value"><?php echo $totalOrders; ?></p>
                        <p class="stat-label">Total Orders</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon pending-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-value"><?php echo $pendingOrders; ?></p>
                        <p class="stat-label">Pending Orders</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon revenue-icon">
                        <i class="bi bi-currency-pound"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-value">£<?php echo number_format($totalRevenue, 2); ?></p>
                        <p class="stat-label">Total Revenue</p>
                    </div>
                </div>
            </div>

            <!-- Recently Added Products -->
            <div class="table-container">
                <div class="table-header">
                    <h2 class="table-title">Recently Added Products</h2>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Stock Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentProducts as $product): ?>
                                <tr>
                                    <td>#<?php echo $product['productID']; ?></td>
                                    <td><?php echo htmlspecialchars($product['fullName']); ?></td>
                                    <td>£<?php echo number_format($product['Price'], 2); ?></td>
                                    <td>
                                        <?php if ($product['stockQuantity'] == 0): ?>
                                            <span class="stock-status stock-out">Out of Stock</span>
                                        <?php elseif ($product['stockQuantity'] < 10): ?>
                                            <span class="stock-status stock-low">Low Stock
                                                (<?php echo $product['stockQuantity']; ?>)</span>
                                        <?php else: ?>
                                            <span class="stock-status stock-ok">In Stock
                                                (<?php echo $product['stockQuantity']; ?>)</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="table-container">
                <div class="table-header">
                    <h2 class="table-title">Recent Orders</h2>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['orderID']; ?></td>
                                    <td><?php echo htmlspecialchars($order['fullName']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($order['orderDate'])); ?></td>
                                    <td>£<?php echo number_format($order['totalPrice'], 2); ?></td>
                                    <td>
                                        <?php
                                        $statusClass = 'badge-pending';
                                        switch (strtolower($order['orderStatus'])) {
                                            case 'shipped':
                                                $statusClass = 'badge-shipped';
                                                break;
                                            case 'delivered':
                                                $statusClass = 'badge-delivered';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'badge-cancelled';
                                                break;
                                        }
                                        ?>
                                        <span class="status-badge <?php echo $statusClass; ?>">
                                            <?php echo htmlspecialchars($order['orderStatus']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
