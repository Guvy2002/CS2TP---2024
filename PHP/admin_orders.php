<?php
session_start();
require_once("dbconnection.php");
ob_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}


if (isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['order_status'];
    $shippingDate = null;

    if ($newStatus === 'Shipped') {
        $shippingDate = date('Y-m-d');
    }

    $updateOrder = $conn->prepare("UPDATE Orders SET orderStatus = ?, shippingDate = ? WHERE orderID = ?");
    $updateOrder->bind_param("ssi", $newStatus, $shippingDate, $orderId);

    if ($updateOrder->execute()) {
        $customerQuery = $conn->prepare("SELECT customerID FROM Orders WHERE orderID = ?");
        $customerQuery->bind_param("i", $orderId);
        $customerQuery->execute();
        $customerResult = $customerQuery->get_result();
        $customerId = $customerResult->fetch_assoc()['customerID'];

        $checkQuery = $conn->prepare("
            SELECT Action FROM OrderHistory 
            WHERE orderID = ? 
            ORDER BY ActionDate DESC 
            LIMIT 1
        ");
        $checkQuery->bind_param("i", $orderId);
        $checkQuery->execute();
        $result = $checkQuery->get_result();
        $lastAction = "Status updated to " . $newStatus;

        if ($result->num_rows === 0 || $result->fetch_assoc()['Action'] !== $lastAction) {
            $action = "Status updated to " . $newStatus;
            $currentDate = date('Y-m-d');
            
            $historyInsert = $conn->prepare("INSERT INTO OrderHistory (customerID, orderID, Action, ActionDate) VALUES (?, ?, ?, ?)");
            $historyInsert->bind_param("iiss", $customerId, $orderId, $action, $currentDate);
            $historyInsert->execute();
        }

        $_SESSION['success_message'] = "Order #$orderId status has been updated to $newStatus.";
    } else {
        $_SESSION['error_message'] = "Error updating order status: " . $conn->error;
    }

    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['customer']) ? '?customer=' . $_GET['customer'] : ''));
    exit();
}


$itemsPerPage = isset($_GET['entries']) ? max(10, min(50, intval($_GET['entries']))) : 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;


$customerFilter = isset($_GET['customer']) ? (int) $_GET['customer'] : null;
$customerName = '';
if ($customerFilter) {
    $customerQuery = $conn->prepare("SELECT fullName FROM Customer WHERE customerID = ?");
    $customerQuery->bind_param("i", $customerFilter);
    $customerQuery->execute();
    $customerResult = $customerQuery->get_result();
    if ($customerResult->num_rows > 0) {
        $customerName = $customerResult->fetch_assoc()['fullName'];
    }
}


$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';


$startDate = isset($_GET['start_date']) && !empty($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : null;


$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';


$whereConditions = [];
$filterParams = [];
$types = "";

if ($customerFilter) {
    $whereConditions[] = "o.customerID = ?";
    $filterParams[] = $customerFilter;
    $types .= "i";
}

if (!empty($statusFilter)) {
    $whereConditions[] = "o.orderStatus = ?";
    $filterParams[] = $statusFilter;
    $types .= "s";
}

if ($startDate) {
    $whereConditions[] = "o.orderDate >= ?";
    $filterParams[] = $startDate;
    $types .= "s";
}

if ($endDate) {
    $whereConditions[] = "o.orderDate <= ?";
    $filterParams[] = $endDate;
    $types .= "s";
}

if (!empty($search)) {
    $whereConditions[] = "(o.orderID LIKE ? OR c.fullName LIKE ? OR c.Email LIKE ?)";
    $searchValue = "%$search%";
    $filterParams[] = $searchValue;
    $filterParams[] = $searchValue;
    $filterParams[] = $searchValue;
    $types .= "sss";
}

$whereClause = '';
if (!empty($whereConditions)) {
    $whereClause = "WHERE " . implode(" AND ", $whereConditions);
}

$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'o.orderDate';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$validOrderColumns = ['o.orderID', 'c.fullName', 'o.orderDate', 'o.totalPrice', 'o.orderStatus'];
$validOrderDirections = ['ASC', 'DESC'];

if (!in_array($orderBy, $validOrderColumns)) {
    $orderBy = 'o.orderDate';
}
if (!in_array($order, $validOrderDirections)) {
    $order = 'DESC';
}


$countQuery = "SELECT COUNT(*) as total FROM Orders o 
               JOIN Customer c ON o.customerID = c.customerID 
               $whereClause";

if (!empty($filterParams)) {
    $stmt = $conn->prepare($countQuery);
    $stmt->bind_param($types, ...$filterParams);
    $stmt->execute();
    $totalOrders = $stmt->get_result()->fetch_assoc()['total'];
} else {
    $result = $conn->query($countQuery);
    $totalOrders = $result->fetch_assoc()['total'];
}

$totalPages = ceil($totalOrders / $itemsPerPage);


$currentPage = max(1, min($currentPage, max(1, $totalPages)));


$ordersQuery = "SELECT o.*, c.fullName, c.Email, 
                (SELECT COUNT(*) FROM OrderItem WHERE orderID = o.orderID) as itemCount 
                FROM Orders o 
                JOIN Customer c ON o.customerID = c.customerID 
                $whereClause 
                ORDER BY $orderBy $order 
                LIMIT ?, ?";

if (!empty($filterParams)) {
    $filterParams[] = $offset;
    $filterParams[] = $itemsPerPage;
    $stmt = $conn->prepare($ordersQuery);
    $stmt->bind_param($types . "ii", ...$filterParams);
} else {
    $stmt = $conn->prepare($ordersQuery);
    $stmt->bind_param("ii", $offset, $itemsPerPage);
}

$stmt->execute();
$orders = $stmt->get_result();


$totalOrdersQuery = "SELECT COUNT(*) as count FROM Orders";
$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalOrdersCount = $totalOrdersResult->fetch_assoc()['count'];

$pendingOrdersQuery = "SELECT COUNT(*) as count FROM Orders WHERE orderStatus = 'Pending'";
$processingOrdersQuery = "SELECT COUNT(*) as count FROM Orders WHERE orderStatus = 'Processing'";
$shippedOrdersQuery = "SELECT COUNT(*) as count FROM Orders WHERE orderStatus = 'Shipped'";

$pendingOrdersResult = $conn->query($pendingOrdersQuery);
$processingOrdersResult = $conn->query($processingOrdersQuery);
$shippedOrdersResult = $conn->query($shippedOrdersQuery);

$pendingOrders = $pendingOrdersResult->fetch_assoc()['count'];
$processingOrders = $processingOrdersResult->fetch_assoc()['count'];
$shippedOrders = $shippedOrdersResult->fetch_assoc()['count'];

$totalRevenueQuery = "SELECT SUM(totalPrice) as total FROM Orders";
$totalRevenueResult = $conn->query($totalRevenueQuery);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total'] ?? 0;

$statusesQuery = "SELECT DISTINCT orderStatus FROM Orders ORDER BY orderStatus";
$statusesResult = $conn->query($statusesQuery);
$orderStatuses = [];
while ($status = $statusesResult->fetch_assoc()) {
    $orderStatuses[] = $status['orderStatus'];
}


function buildPaginationUrl($page, $entries, $orderBy, $order, $search, $customerFilter, $statusFilter, $startDate, $endDate)
{
    $params = [
        'page' => $page,
        'entries' => $entries,
        'orderBy' => $orderBy,
        'order' => $order
    ];

    if (!empty($search)) {
        $params['search'] = $search;
    }

    if ($customerFilter) {
        $params['customer'] = $customerFilter;
    }

    if (!empty($statusFilter)) {
        $params['status'] = $statusFilter;
    }

    if ($startDate) {
        $params['start_date'] = $startDate;
    }

    if ($endDate) {
        $params['end_date'] = $endDate;
    }

    return '?' . http_build_query($params);
}

function getNextOrder($currentColumn, $currentOrder, $orderBy)
{
    if ($currentColumn === $orderBy) {
        return $currentOrder === 'ASC' ? 'DESC' : 'ASC';
    }
    return 'ASC';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --danger-color: #ff4d6d;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --transition: all 0.3s ease;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --transition-speed: 0.3s;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            line-height: 1.6;
            color: var(--dark-color);
        }

        .dashboard-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-header {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-header h1 {
            font-size: 1.8rem;
            color: var(--dark-color);
            margin: 0;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) ease;
            width: calc(100% - var(--sidebar-width));
            padding: 0;
        }

        .admin-container.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: var(--sidebar-collapsed-width);
                width: calc(100% - var(--sidebar-collapsed-width));
            }
        }

        .admin-controls {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .btn-secondary {
            background-color: var(--gray-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #e8364c;
        }

        .btn.active {
            background-color: var(--secondary-color);
            color: white;
        }

        .search-filter-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .search-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .search-box {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .search-box:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 150px;
        }

        .filter-group label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        .filter-group select,
        .filter-group input[type="date"],
        .filter-group input[type="text"] {
            padding: 12px 15px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .filter-group select:focus,
        .filter-group input[type="date"]:focus,
        .filter-group input[type="text"]:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .customer-filter-notice {
            background-color: rgba(67, 97, 238, 0.1);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid var(--primary-color);
        }

        .customer-filter-notice p {
            margin: 0;
        }

        .clear-filter {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-card i {
            margin-bottom: 15px;
            color: var(--primary-color);
            font-size: 2rem;
        }

        .stat-card h3 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .stat-card p {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .table-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h2 {
            font-size: 1.5rem;
            color: var(--dark-color);
        }

        .entries-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .entries-control select {
            padding: 8px;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .orders-table th,
        .orders-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e1e1e1;
        }

        .orders-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--dark-color);
        }

        .orders-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .orders-table th a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .orders-table th a i {
            margin-left: 5px;
        }


        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            text-align: center;
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

        .status-returned {
    		background-color: #e2e3e5;  
    		color: #383d41;  
		}


        .customer-info {
            display: flex;
            flex-direction: column;
        }

        .customer-email {
            font-size: 12px;
            color: #666;
        }


        .items-column {
            text-align: center;
        }

        .items-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            height: 24px;
            padding: 0 8px;
            border-radius: 12px;
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.85rem;
        }


        .actions-column {
            
            gap: 8px;
            justify-content: center;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .edit-btn {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.1);
        }

        .edit-btn:hover {
            background-color: rgba(67, 97, 238, 0.2);
        }

        .view-btn {
            color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
            text-decoration: none;
        }

        .view-btn:hover {
            background-color: rgba(40, 167, 69, 0.2);
        }


        .no-results {
            padding: 30px;
            text-align: center;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }


        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e1e1e1;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .pagination-controls {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .ellipsis {
            padding: 0 5px;
        }


        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
        }

        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }

        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
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
            margin: 8% auto;
            padding: 25px;
            border: 1px solid #ddd;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close:hover {
            color: #333;
        }

        .modal h2 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-group select:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.1);
        }

        .status-note {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 4px;
            margin: 15px 0;
            font-size: 14px;
            border-left: 3px solid #6b7280;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
        }

        .cancel-btn {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .cancel-btn:hover {
            background-color: #e9ecef;
        }

        .save-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .save-btn:hover {
            background-color: var(--secondary-color);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        @media (max-width: 768px) {
            .search-filter-container {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }

            .admin-controls {
                flex-wrap: wrap;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
            }

            .pagination {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .pagination-controls {
                flex-wrap: wrap;
            }

            .modal-content {
                width: 90%;
                margin: 20% auto;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container" id="adminContainer">
        <?php
        $_GET['page'] = 'orders';
        include 'admin_sidebar.php';
        ?>
        <div class="main-content">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <h1><i class="fas fa-shopping-cart"></i> Order Management</h1>
                </div>

                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <?php
                        echo htmlspecialchars($_SESSION['success_message']);
                        unset($_SESSION['success_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger">
                        <?php
                        echo htmlspecialchars($_SESSION['error_message']);
                        unset($_SESSION['error_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($customerFilter): ?>
                    <div class="customer-filter-notice">
                        <p><i class="fas fa-user"></i> Showing orders for:
                            <strong><?php echo htmlspecialchars($customerName); ?> (ID:
                                <?php echo $customerFilter; ?>)</strong>
                        </p>
                        <a href="admin_orders.php" class="clear-filter">Clear Customer Filter</a>
                    </div>
                <?php endif; ?>

                <form method="GET" class="search-filter-container">
                    <?php if ($customerFilter): ?>
                        <input type="hidden" name="customer" value="<?php echo $customerFilter; ?>">
                    <?php endif; ?>

                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="search-box" placeholder="Search orders..."
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>

                    <div class="filter-group">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="">All Statuses</option>
                            <?php foreach ($orderStatuses as $status): ?>
                                <option value="<?php echo $status; ?>" <?php echo ($statusFilter === $status) ? 'selected' : ''; ?>>
                                    <?php echo $status; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="start_date">From Date</label>
                        <input type="date" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
                    </div>

                    <div class="filter-group">
                        <label for="end_date">To Date</label>
                        <input type="date" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>

                    <a href="admin_orders.php<?php echo $customerFilter ? '?customer=' . $customerFilter : ''; ?>"
                        class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset Filters
                    </a>
                </form>

                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                        <h3>Total Orders</h3>
                        <p><?php echo $totalOrdersCount; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-hourglass-half fa-2x"></i>
                        <h3>Pending Orders</h3>
                        <p><?php echo $pendingOrders; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-truck fa-2x"></i>
                        <h3>Shipped Orders</h3>
                        <p><?php echo $shippedOrders; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-pound-sign fa-2x"></i>
                        <h3>Total Revenue</h3>
                        <p>£<?php echo number_format($totalRevenue, 2); ?></p>
                    </div>
                </div>

                <?php if ($orders->num_rows === 0): ?>
                    <div class="no-results">
                        <i class="fas fa-search fa-2x" style="color: #6b7280; margin-bottom: 15px;"></i>
                        <h3>No Orders Found</h3>
                        <p>No orders match your current search criteria.</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <div class="table-header">
                            <h2><i class="fas fa-list"></i> Order List</h2>
                            <form method="GET" class="entries-control">
                                <label>
                                    Show
                                    <select name="entries" onchange="this.form.submit()">
                                        <option value="10" <?php echo $itemsPerPage == 10 ? 'selected' : ''; ?>>10</option>
                                        <option value="25" <?php echo $itemsPerPage == 25 ? 'selected' : ''; ?>>25</option>
                                        <option value="50" <?php echo $itemsPerPage == 50 ? 'selected' : ''; ?>>50</option>
                                    </select>
                                    entries
                                </label>
                                <?php if (!empty($search)): ?>
                                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                <?php endif; ?>
                                <?php if (!empty($statusFilter)): ?>
                                    <input type="hidden" name="status" value="<?php echo htmlspecialchars($statusFilter); ?>">
                                <?php endif; ?>
                                <?php if ($startDate): ?>
                                    <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
                                <?php endif; ?>
                                <?php if ($endDate): ?>
                                    <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">
                                <?php endif; ?>
                                <?php if ($customerFilter): ?>
                                    <input type="hidden" name="customer" value="<?php echo $customerFilter; ?>">
                                <?php endif; ?>
                                <input type="hidden" name="orderBy" value="<?php echo htmlspecialchars($orderBy); ?>">
                                <input type="hidden" name="order" value="<?php echo htmlspecialchars($order); ?>">
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th width="7%" class="text-center">
                                            <a
                                                href="<?php echo buildPaginationUrl(1, $itemsPerPage, 'o.orderID', getNextOrder('o.orderID', $order, $orderBy), $search, $customerFilter, $statusFilter, $startDate, $endDate); ?>">
                                                Order ID
                                                <?php if ($orderBy === 'o.orderID'): ?>
                                                    <i
                                                        class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                                <?php endif; ?>
                                            </a>
                                        </th>
                                        <th width="25%">
                                            <a
                                                href="<?php echo buildPaginationUrl(1, $itemsPerPage, 'c.fullName', getNextOrder('c.fullName', $order, $orderBy), $search, $customerFilter, $statusFilter, $startDate, $endDate); ?>">
                                                Customer
                                                <?php if ($orderBy === 'c.fullName'): ?>
                                                    <i
                                                        class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                                <?php endif; ?>
                                            </a>
                                        </th>
                                        <th width="15%">
                                            <a
                                                href="<?php echo buildPaginationUrl(1, $itemsPerPage, 'o.orderDate', getNextOrder('o.orderDate', $order, $orderBy), $search, $customerFilter, $statusFilter, $startDate, $endDate); ?>">
                                                Date
                                                <?php if ($orderBy === 'o.orderDate'): ?>
                                                    <i
                                                        class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                                <?php endif; ?>
                                            </a>
                                        </th>
                                        <th width="8%" class="text-center">Items</th>
                                        <th width="15%" class="text-right">
                                            <a
                                                href="<?php echo buildPaginationUrl(1, $itemsPerPage, 'o.totalPrice', getNextOrder('o.totalPrice', $order, $orderBy), $search, $customerFilter, $statusFilter, $startDate, $endDate); ?>">
                                                Total
                                                <?php if ($orderBy === 'o.totalPrice'): ?>
                                                    <i
                                                        class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                                <?php endif; ?>
                                            </a>
                                        </th>
                                        <th width="15%" class="text-center">
                                            <a
                                                href="<?php echo buildPaginationUrl(1, $itemsPerPage, 'o.orderStatus', getNextOrder('o.orderStatus', $order, $orderBy), $search, $customerFilter, $statusFilter, $startDate, $endDate); ?>">
                                                Status
                                                <?php if ($orderBy === 'o.orderStatus'): ?>
                                                    <i
                                                        class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                                <?php endif; ?>
                                            </a>
                                        </th>
                                        <th width="15%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($order = $orders->fetch_assoc()): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $order['orderID']; ?></td>
                                            <td>
                                                <div class="customer-info">
                                                    <div><?php echo htmlspecialchars($order['fullName']); ?></div>
                                                    <div class="customer-email"><?php echo htmlspecialchars($order['Email']); ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($order['orderDate'])); ?></td>
                                            <td class="items-column">
                                                <span class="items-badge"><?php echo $order['itemCount']; ?></span>
                                            </td>
                                            <td class="text-right">£<?php echo number_format($order['totalPrice'], 2); ?></td>
                                            <td class="text-center">
                                                <span
                                                    class="status-badge status-<?php echo strtolower($order['orderStatus']); ?>">
                                                    <?php echo $order['orderStatus']; ?>
                                                </span>
                                            </td>
                                            <td class="actions-column">
                                                <button
                                                    onclick="editOrderStatus(<?php echo $order['orderID']; ?>, '<?php echo $order['orderStatus']; ?>')"
                                                    class="action-btn edit-btn" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="admin_view_order.php?id=<?php echo $order['orderID']; ?>"
                                                    class="action-btn view-btn" title="View Order Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination">
                            <div class="pagination-info">
                                Showing <?php echo $offset + 1; ?> to
                                <?php echo min($offset + $itemsPerPage, $totalOrders); ?>
                                of
                                <?php echo $totalOrders; ?> orders
                            </div>
                            <div class="pagination-controls">
                                <?php if ($totalPages > 1): ?>
                                    <?php if ($currentPage > 1): ?>
                                        <a href="<?php echo buildPaginationUrl($currentPage - 1, $itemsPerPage, $orderBy, $order, $search, $customerFilter, $statusFilter, $startDate, $endDate); ?>"
                                            class="btn">
                                            <i class="fas fa-chevron-left"></i> Previous
                                        </a>
                                    <?php endif; ?>

                                    <?php

                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($totalPages, $currentPage + 2);

                                    if ($startPage > 1) {
                                        echo '<a href="' . buildPaginationUrl(1, $itemsPerPage, $orderBy, $order, $search, $customerFilter, $statusFilter, $startDate, $endDate) . '" class="btn">1</a>';
                                        if ($startPage > 2) {
                                            echo '<span class="ellipsis">...</span>';
                                        }
                                    }

                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        echo '<a href="' . buildPaginationUrl($i, $itemsPerPage, $orderBy, $order, $search, $customerFilter, $statusFilter, $startDate, $endDate) . '" 
                                    class="btn ' . ($i === $currentPage ? 'active' : '') . '">' . $i . '</a>';
                                    }

                                    if ($endPage < $totalPages) {
                                        if ($endPage < $totalPages - 1) {
                                            echo '<span class="ellipsis">...</span>';
                                        }
                                        echo '<a href="' . buildPaginationUrl($totalPages, $itemsPerPage, $orderBy, $order, $search, $customerFilter, $statusFilter, $startDate, $endDate) . '" class="btn">' . $totalPages . '</a>';
                                    }
                                    ?>

                                    <?php if ($currentPage < $totalPages): ?>
                                        <a href="<?php echo buildPaginationUrl($currentPage + 1, $itemsPerPage, $orderBy, $order, $search, $customerFilter, $statusFilter, $startDate, $endDate); ?>"
                                            class="btn">
                                            Next <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <div id="statusModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Update Order Status</h2>
                    <form method="POST" action="">
                        <input type="hidden" id="order_id" name="order_id">
                        <div class="form-group">
                            <label for="order_status">Status:</label>
                            <select id="order_status" name="order_status" required>
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Returned">Returned</option>
                            </select>
                        </div>
                        <div class="status-note">
                            <p><strong>Note:</strong> Changing status to 'Shipped' will automatically set today's date
                                as
                                the shipping date.</p>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                            <button type="submit" name="update_status" class="save-btn">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>

    const statusModal = document.getElementById('statusModal');
    const closeButton = document.getElementsByClassName('close')[0];

    function editOrderStatus(orderId, currentStatus) {
        document.getElementById('order_id').value = orderId;
        document.getElementById('order_status').value = currentStatus;
        statusModal.style.display = 'block';
    }

    function closeModal() {
        statusModal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == statusModal) {
            closeModal();
        }
    }
</script>

</html>