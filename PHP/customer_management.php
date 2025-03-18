<?php
session_start();
require_once("dbconnection.php");
ob_start();


if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}



if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $customerId = $_GET['delete'];


    $checkOrders = $conn->prepare("SELECT COUNT(*) as orderCount FROM Orders WHERE customerID = ?");
    $checkOrders->bind_param("i", $customerId);
    $checkOrders->execute();
    $orderResult = $checkOrders->get_result();
    $orderCount = $orderResult->fetch_assoc()['orderCount'];

    if ($orderCount > 0) {
        $_SESSION['error_message'] = "Cannot delete customer #$customerId because they have $orderCount orders in the system.";
    } else {
        $checkBasket = $conn->prepare("SELECT basketID FROM Basket WHERE customerID = ?");
        $checkBasket->bind_param("i", $customerId);
        $checkBasket->execute();
        $basketResult = $checkBasket->get_result();

        $conn->begin_transaction();

        try {
            if ($basketResult->num_rows > 0) {
                $basketID = $basketResult->fetch_assoc()['basketID'];
                $deleteBasketItems = $conn->prepare("DELETE FROM BasketItem WHERE basketID = ?");
                $deleteBasketItems->bind_param("i", $basketID);
                $deleteBasketItems->execute();

                $deleteBasket = $conn->prepare("DELETE FROM Basket WHERE basketID = ?");
                $deleteBasket->bind_param("i", $basketID);
                $deleteBasket->execute();
            }

            $checkWishlist = $conn->prepare("SELECT wishlistID FROM Wishlist WHERE customerID = ?");
            $checkWishlist->bind_param("i", $customerId);
            $checkWishlist->execute();
            $wishlistResult = $checkWishlist->get_result();

            if ($wishlistResult->num_rows > 0) {
                $wishlistID = $wishlistResult->fetch_assoc()['wishlistID'];
                $deleteWishlistItems = $conn->prepare("DELETE FROM WishlistItem WHERE wishlistID = ?");
                $deleteWishlistItems->bind_param("i", $wishlistID);
                $deleteWishlistItems->execute();

                $deleteWishlist = $conn->prepare("DELETE FROM Wishlist WHERE wishlistID = ?");
                $deleteWishlist->bind_param("i", $wishlistID);
                $deleteWishlist->execute();
            }

            $deleteCustomer = $conn->prepare("DELETE FROM Customer WHERE customerID = ?");
            $deleteCustomer->bind_param("i", $customerId);
            $deleteCustomer->execute();

            $conn->commit();

            $_SESSION['success_message'] = "Customer #$customerId has been successfully deleted.";
        } catch (Exception $e) {

            $conn->rollback();
            $_SESSION['error_message'] = "Error deleting customer: " . $e->getMessage();
        }
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['update_customer'])) {
    $customerId = $_POST['customer_id'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
    } else {
        $checkEmail = $conn->prepare("SELECT customerID FROM Customer WHERE Email = ? AND customerID != ?");
        $checkEmail->bind_param("si", $email, $customerId);
        $checkEmail->execute();
        $emailResult = $checkEmail->get_result();

        if ($emailResult->num_rows > 0) {
            $_SESSION['error_message'] = "Email address is already in use by another customer.";
        } else {

            $updateCustomer = $conn->prepare("UPDATE Customer SET fullName = ?, Email = ? WHERE customerID = ?");
            $updateCustomer->bind_param("ssi", $fullName, $email, $customerId);

            if ($updateCustomer->execute()) {
                $_SESSION['success_message'] = "Customer #$customerId has been updated successfully.";
            } else {
                $_SESSION['error_message'] = "Error updating customer: " . $conn->error;
            }
        }
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$itemsPerPage = isset($_GET['entries']) ? max(10, min(50, intval($_GET['entries']))) : 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$searchCondition = '';
if (!empty($search)) {
    $searchCondition = " WHERE fullName LIKE '%$search%' OR Email LIKE '%$search%' OR customerID LIKE '%$search%'";
}

$countQuery = $conn->query("SELECT COUNT(*) as total FROM Customer" . $searchCondition);
$totalCustomers = $countQuery->fetch_assoc()['total'];
$totalPages = ceil($totalCustomers / $itemsPerPage);

$currentPage = max(1, min($currentPage, max(1, $totalPages)));

$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'customerID';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$validOrderColumns = ['customerID', 'fullName', 'Email', 'RegistrationDate'];
$validOrderDirections = ['ASC', 'DESC'];

if (!in_array($orderBy, $validOrderColumns)) {
    $orderBy = 'customerID';
}
if (!in_array($order, $validOrderDirections)) {
    $order = 'ASC';
}

$customersQuery = "SELECT c.*, 
                          (SELECT COUNT(*) FROM Orders WHERE customerID = c.customerID) as orderCount,
                          (SELECT SUM(totalPrice) FROM Orders WHERE customerID = c.customerID) as totalSpent
                   FROM Customer c
                   $searchCondition
                   ORDER BY $orderBy $order
                   LIMIT $offset, $itemsPerPage";
$customers = $conn->query($customersQuery);

$customersWithOrdersSql = "SELECT COUNT(DISTINCT c.customerID) as count 
                           FROM Customer c 
                           JOIN Orders o ON c.customerID = o.customerID";
$customersWithOrdersResult = $conn->query($customersWithOrdersSql);
$customersWithOrders = $customersWithOrdersResult->fetch_assoc()['count'];

$recentCustomersSql = "SELECT COUNT(*) as count 
                       FROM Customer 
                       WHERE RegistrationDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
$recentCustomersResult = $conn->query($recentCustomersSql);
$recentCustomers = $recentCustomersResult->fetch_assoc()['count'];

$totalRevenueSql = "SELECT SUM(totalPrice) as total FROM Orders";
$totalRevenueResult = $conn->query($totalRevenueSql);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total'] ?? 0;

function buildPaginationUrl($page, $entries, $orderBy, $order, $search)
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
    <title>Customer Management Dashboard</title>
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

        /* Responsive adjustments */
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
            gap: 15px;
            align-items: center;
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

        .customers-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .customers-table th,
        .customers-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e1e1e1;
        }

        .customers-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--dark-color);
        }

        .customers-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .customers-table th a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .customers-table th a i {
            margin-left: 5px;
        }

        .orders-column {
            text-align: center;
        }

        .orders-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .orders-high {
            background-color: #ecfdf5;
            color: #059669;
        }

        .orders-medium {
            background-color: #f9fafb;
            color: #4b5563;
        }

        .orders-none {
            background-color: #fff1f2;
            color: var(--danger-color);
        }

        .view-orders-btn {
            color: var(--primary-color);
            text-decoration: none;
            margin-left: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: rgba(67, 97, 238, 0.1);
            transition: background-color 0.2s;
        }

        .view-orders-btn:hover {
            background-color: rgba(67, 97, 238, 0.2);
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .action-btn {
            background: none;
            border: none;
            font-size: 1rem;
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

        .delete-btn {
            color: var(--danger-color);
            background-color: rgba(255, 77, 109, 0.1);
        }

        .delete-btn:hover {
            background-color: rgba(255, 77, 109, 0.2);
        }

        .delete-btn.disabled {
            color: #aaa;
            background-color: #f5f5f5;
            cursor: not-allowed;
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

        .no-results {
            text-align: center;
            padding: 30px;
            color: #6b7280;
            font-style: italic;
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

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.1);
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

        @media (max-width: 768px) {
            .search-filter-container {
                flex-direction: column;
                align-items: stretch;
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
            }
        }
    </style>
</head>

<body>
    <div class="admin-container" id="adminContainer">
        <?php
        $_GET['page'] = 'customers';
        include 'admin_sidebar.php';
        ?>
        <div class="main-content">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <h1><i class="fas fa-users"></i> Customer Management</h1>
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

                <form method="GET" class="search-filter-container">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="search-box"
                            placeholder="Search customers by name, email or ID..."
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                    <?php if (!empty($search)): ?>
                        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="btn btn-secondary">Clear</a>
                    <?php endif; ?>
                </form>

                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-users fa-2x"></i>
                        <h3>Total Customers</h3>
                        <p><?php echo $totalCustomers; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                        <h3>Customers with Orders</h3>
                        <p><?php echo $customersWithOrders; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-user-plus fa-2x"></i>
                        <h3>New Customers (30 days)</h3>
                        <p><?php echo $recentCustomers; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-pound-sign fa-2x"></i>
                        <h3>Total Revenue</h3>
                        <p>£<?php echo number_format($totalRevenue, 2); ?></p>
                    </div>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2><i class="fas fa-list"></i> Customer List</h2>
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
                            <input type="hidden" name="orderBy" value="<?php echo htmlspecialchars($orderBy); ?>">
                            <input type="hidden" name="order" value="<?php echo htmlspecialchars($order); ?>">
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="customers-table">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <a
                                            href="<?php echo buildPaginationUrl($currentPage, $itemsPerPage, 'customerID', getNextOrder('customerID', $order, $orderBy), $search); ?>">
                                            ID
                                            <?php if ($orderBy === 'customerID'): ?>
                                                <i
                                                    class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th width="20%">
                                        <a
                                            href="<?php echo buildPaginationUrl($currentPage, $itemsPerPage, 'fullName', getNextOrder('fullName', $order, $orderBy), $search); ?>">
                                            Name
                                            <?php if ($orderBy === 'fullName'): ?>
                                                <i
                                                    class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th width="25%">
                                        <a
                                            href="<?php echo buildPaginationUrl($currentPage, $itemsPerPage, 'Email', getNextOrder('Email', $order, $orderBy), $search); ?>">
                                            Email
                                            <?php if ($orderBy === 'Email'): ?>
                                                <i
                                                    class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th width="15%">
                                        <a
                                            href="<?php echo buildPaginationUrl($currentPage, $itemsPerPage, 'RegistrationDate', getNextOrder('RegistrationDate', $order, $orderBy), $search); ?>">
                                            Registration Date
                                            <?php if ($orderBy === 'RegistrationDate'): ?>
                                                <i
                                                    class="fas fa-sort-<?php echo strtolower($order) === 'asc' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th width="10%" class="text-center">Orders</th>
                                    <th width="15%" class="text-right">Total Spent</th>
                                    <th width="10%" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($customers->num_rows === 0): ?>
                                    <tr>
                                        <td colspan="7" class="no-results">
                                            <?php if (!empty($search)): ?>
                                                <p>No customers found matching "<?php echo htmlspecialchars($search); ?>".</p>
                                            <?php else: ?>
                                                <p>No customers found in the database.</p>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php while ($customer = $customers->fetch_assoc()): ?>
                                        <tr id="customer-<?php echo $customer['customerID']; ?>">
                                            <td><?php echo htmlspecialchars($customer['customerID']); ?></td>
                                            <td data-field="fullName" data-id="<?php echo $customer['customerID']; ?>">
                                                <?php echo htmlspecialchars($customer['fullName']); ?>
                                            </td>
                                            <td data-field="email" data-id="<?php echo $customer['customerID']; ?>">
                                                <?php echo htmlspecialchars($customer['Email']); ?>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($customer['RegistrationDate'])); ?></td>
                                            <td class="orders-column">
                                                <?php if ($customer['orderCount'] > 0): ?>
                                                    <span
                                                        class="orders-badge <?php echo $customer['orderCount'] > 5 ? 'orders-high' : 'orders-medium'; ?>">
                                                        <?php echo $customer['orderCount']; ?>
                                                        <a href="admin_orders.php?customer=<?php echo $customer['customerID']; ?>"
                                                            class="view-orders-btn" title="View Orders">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="orders-badge orders-none">0</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo $customer['totalSpent'] ? '£' . number_format($customer['totalSpent'], 2) : '£0.00'; ?>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button
                                                        onclick="editCustomer(<?php echo $customer['customerID']; ?>, '<?php echo htmlspecialchars(addslashes($customer['fullName'])); ?>', '<?php echo htmlspecialchars(addslashes($customer['Email'])); ?>')"
                                                        class="action-btn edit-btn" title="Edit Customer">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <?php if ($customer['orderCount'] == 0): ?>
                                                        <button onclick="confirmDelete(<?php echo $customer['customerID']; ?>)"
                                                            class="action-btn delete-btn" title="Delete Customer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button disabled class="action-btn delete-btn disabled"
                                                            title="Cannot delete customer with orders">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($totalCustomers > 0): ?>
                        <div class="pagination">
                            <div class="pagination-info">
                                Showing <?php echo $offset + 1; ?> to
                                <?php echo min($offset + $itemsPerPage, $totalCustomers); ?>
                                of
                                <?php echo $totalCustomers; ?> customers
                            </div>
                            <div class="pagination-controls">
                                <?php if ($totalPages > 1): ?>
                                    <?php if ($currentPage > 1): ?>
                                        <a href="<?php echo buildPaginationUrl($currentPage - 1, $itemsPerPage, $orderBy, $order, $search); ?>"
                                            class="btn">
                                            <i class="fas fa-chevron-left"></i> Previous
                                        </a>
                                    <?php endif; ?>

                                    <?php

                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($totalPages, $currentPage + 2);

                                    if ($startPage > 1) {
                                        echo '<a href="' . buildPaginationUrl(1, $itemsPerPage, $orderBy, $order, $search) . '" class="btn">1</a>';
                                        if ($startPage > 2) {
                                            echo '<span class="ellipsis">...</span>';
                                        }
                                    }

                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        echo '<a href="' . buildPaginationUrl($i, $itemsPerPage, $orderBy, $order, $search) . '" 
                                    class="btn ' . ($i === $currentPage ? 'active' : '') . '">' . $i . '</a>';
                                    }

                                    if ($endPage < $totalPages) {
                                        if ($endPage < $totalPages - 1) {
                                            echo '<span class="ellipsis">...</span>';
                                        }
                                        echo '<a href="' . buildPaginationUrl($totalPages, $itemsPerPage, $orderBy, $order, $search) . '" class="btn">' . $totalPages . '</a>';
                                    }
                                    ?>

                                    <?php if ($currentPage < $totalPages): ?>
                                        <a href="<?php echo buildPaginationUrl($currentPage + 1, $itemsPerPage, $orderBy, $order, $search); ?>"
                                            class="btn">
                                            Next <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Edit Customer</h2>
                    <form id="edit-form" method="POST" action="">
                        <input type="hidden" id="customer_id" name="customer_id">
                        <div class="form-group">
                            <label for="fullName">Full Name:</label>
                            <input type="text" id="fullName" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                            <button type="submit" name="update_customer" class="save-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
<script>

    const modal = document.getElementById('editModal');

    function editCustomer(customerId, name, email) {

        document.getElementById('customer_id').value = customerId;
        document.getElementById('fullName').value = name;
        document.getElementById('email').value = email;

        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    function confirmDelete(customerId) {
        if (confirm('Are you sure you want to delete this customer? This action cannot be undone.')) {
            window.location.href = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?delete=' + customerId;
        }
    }
</script>

</html>
