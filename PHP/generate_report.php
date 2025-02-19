<?php
session_start();
require_once("dbconnection.php");

// Check if user is admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    $_SESSION['error_message'] = "Unauthorized access";
    header('Location: inventory_dashboard.php');
    exit();
}

// Get report type from request
$reportType = isset($_GET['type']) ? $_GET['type'] : 'full';
$format = isset($_GET['format']) ? $_GET['format'] : 'csv';

// Define the filename
$timestamp = date('Y-m-d_H-i-s');
$filename = "inventory_report_{$reportType}_{$timestamp}";

// Set headers based on format
if ($format === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
} else {
    // Default to CSV if invalid format
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
}

// Create output handle
$output = fopen('php://output', 'w');

// Get report data based on type
switch ($reportType) {
    case 'low_stock':
        $sql = "SELECT p.productID, p.ModelNo, p.fullName, c.categoryName, 
                p.stockQuantity, p.Price, p.Description,
                (SELECT COUNT(*) FROM OrderItem oi 
                 JOIN Orders o ON oi.orderID = o.orderID 
                 WHERE oi.productID = p.productID 
                 AND o.orderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as monthly_sales
                FROM Products p
                LEFT JOIN Category c ON p.categoryID = c.categoryID
                WHERE p.stockQuantity < 10
                ORDER BY p.stockQuantity ASC";
        
        // Headers for low stock report
        fputcsv($output, [
            'Product ID', 'Model No', 'Product Name', 'Category', 
            'Stock Quantity', 'Price (£)', 'Monthly Sales', 'Description'
        ]);
        break;
        
    case 'sales':
        $sql = "SELECT p.productID, p.ModelNo, p.fullName, c.categoryName,
                p.stockQuantity, p.Price,
                COUNT(oi.orderItemID) as total_sales,
                SUM(oi.quantity) as units_sold,
                SUM(oi.quantity * oi.priceAtTime) as revenue
                FROM Products p
                LEFT JOIN Category c ON p.categoryID = c.categoryID
                LEFT JOIN OrderItem oi ON p.productID = oi.productID
                LEFT JOIN Orders o ON oi.orderID = o.orderID
                WHERE o.orderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                GROUP BY p.productID
                ORDER BY units_sold DESC";
        
        // Headers for sales report
        fputcsv($output, [
            'Product ID', 'Model No', 'Product Name', 'Category',
            'Current Stock', 'Current Price (£)', 'Total Sales',
            'Units Sold', 'Revenue (£)'
        ]);
        break;
        
    case 'category':
        $sql = "SELECT c.categoryName,
                COUNT(p.productID) as total_products,
                SUM(p.stockQuantity) as total_stock,
                AVG(p.Price) as avg_price,
                SUM(CASE WHEN p.stockQuantity < 10 THEN 1 ELSE 0 END) as low_stock_items
                FROM Category c
                LEFT JOIN Products p ON c.categoryID = p.categoryID
                GROUP BY c.categoryID
                ORDER BY total_products DESC";
        
        // Headers for category report
        fputcsv($output, [
            'Category', 'Total Products', 'Total Stock',
            'Average Price (£)', 'Low Stock Items'
        ]);
        break;
        
    default: // full inventory report
        $sql = "SELECT p.productID, p.ModelNo, p.fullName, c.categoryName,
                p.stockQuantity, p.Price, p.Description,
                (SELECT COUNT(*) FROM OrderItem oi 
                 JOIN Orders o ON oi.orderID = o.orderID 
                 WHERE oi.productID = p.productID 
                 AND o.orderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as monthly_sales
                FROM Products p
                LEFT JOIN Category c ON p.categoryID = c.categoryID
                ORDER BY c.categoryName, p.fullName";
        
        // Headers for full report
        fputcsv($output, [
            'Product ID', 'Model No', 'Product Name', 'Category',
            'Stock Quantity', 'Price (£)', 'Monthly Sales', 'Description'
        ]);
}

// Execute query
$result = $conn->query($sql);

// Write data rows
while ($row = $result->fetch_assoc()) {
    // Clean the data before writing
    array_walk($row, function(&$value) {
        // Remove any potential CSV injection characters
        if (is_string($value)) {
            $value = str_replace(["\r", "\n", "\t"], ' ', $value);
            // Remove any potential formula injection for spreadsheet software
            if (strlen($value) > 0 && in_array($value[0], ['=', '+', '-', '@'])) {
                $value = "'" . $value;
            }
        }
    });
    
    fputcsv($output, $row);
}

// Close the output handle
fclose($output);
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Inventory Report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Same CSS as other pages */
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --danger-color: #ff4d6d;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            line-height: 1.6;
            color: var(--dark-color);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-file-export"></i> Generate Inventory Report</h1>
        
        <p>Select the type of report you want to generate:</p>
        
        <div class="btn-group">
            <a href="?type=full" class="btn btn-primary">
                <i class="fas fa-file-alt"></i> Full Inventory Report
            </a>
            <a href="?type=low_stock" class="btn btn-primary">
                <i class="fas fa-exclamation-triangle"></i> Low Stock Report
            </a>
            <a href="?type=sales" class="btn btn-primary">
                <i class="fas fa-chart-line"></i> Sales Report
            </a>
            <a href="?type=category" class="btn btn-primary">
                <i class="fas fa-tags"></i> Category Report
            </a>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="inventory_dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html><?php
session_start();
require_once("dbconnection.php");

// Check if user is admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="inventory_report_' . date('Y-m-d') . '.csv"');

// Create output stream
$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, array(
    'Product ID',
    'Model No',
    'Name',
    'Category',
    'Stock Quantity',
    'Price',
    'Monthly Sales',
    'Stock Status'
));

// Fetch all products with their details
$sql = "SELECT p.*, c.categoryName,
        (SELECT COUNT(*) FROM OrderItem oi 
         JOIN Orders o ON oi.orderID = o.orderID 
         WHERE oi.productID = p.productID 
         AND o.orderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as monthly_sales
        FROM Products p
        LEFT JOIN Category c ON p.categoryID = c.categoryID";

$result = $conn->query($sql);

// Add data rows
while ($row = $result->fetch_assoc()) {
    $stockStatus = $row['stockQuantity'] == 0 ? 'Out of Stock' : 
                  ($row['stockQuantity'] < 10 ? 'Low Stock' : 'In Stock');
    
    fputcsv($output, array(
        $row['productID'],
        $row['ModelNo'],
        $row['fullName'],
        $row['categoryName'],
        $row['stockQuantity'],
        $row['Price'],
        $row['monthly_sales'],
        $stockStatus
    ));
}

fclose($output);