<?php
session_start();
require_once("dbconnection.php");

//security check for admin
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

$generateReport = isset($_GET['type']);

if ($generateReport) {
    $validTypes = ['full', 'low_stock', 'sales', 'category'];
    $validFormats = ['csv', 'excel'];

    $reportType = isset($_GET['type']) && in_array($_GET['type'], $validTypes) ? $_GET['type'] : 'full';
    $format = isset($_GET['format']) && in_array($_GET['format'], $validFormats) ? $_GET['format'] : 'csv';

    $timestamp = date('Y-m-d_H-i-s');
    $filename = "inventory_report_{$reportType}_{$timestamp}";

    if ($format === 'excel') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
    } else {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
    }

    $output = fopen('php://output', 'w');

    if ($format === 'excel') {
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
    }

    try {
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

                fputcsv($output, [
                    'Product ID',
                    'Model No',
                    'Product Name',
                    'Category',
                    'Stock Quantity',
                    'Price (£)',
                    'Monthly Sales',
                    'Description'
                ]);
                break;

            case 'sales':
                $sql = "SELECT p.productID, p.ModelNo, p.fullName, c.categoryName,
        p.stockQuantity, p.Price,
        (SELECT COUNT(*) FROM OrderItem oi 
         JOIN Orders o ON oi.orderID = o.orderID 
         WHERE oi.productID = p.productID 
         AND o.orderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as monthly_sales,
        p.Description
        FROM Products p
        LEFT JOIN Category c ON p.categoryID = c.categoryID
        ORDER BY c.categoryName, p.fullName";

                fputcsv($output, [
                    'Product ID',
                    'Model No',
                    'Product Name',
                    'Category',
                    'Current Stock',
                    'Current Price (£)',
                    'Total Sales',
                    'Units Sold',
                    'Revenue (£)'
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

                fputcsv($output, [
                    'Category',
                    'Total Products',
                    'Total Stock',
                    'Average Price (£)',
                    'Low Stock Items'
                ]);
                break;

            default: 
                $sql = "SELECT p.productID, p.ModelNo, p.fullName, c.categoryName,
                        p.stockQuantity, p.Price, p.Description,
                        (SELECT COUNT(*) FROM OrderItem oi 
                         JOIN Orders o ON oi.orderID = o.orderID 
                         WHERE oi.productID = p.productID 
                         AND o.orderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as monthly_sales
                        FROM Products p
                        LEFT JOIN Category c ON p.categoryID = c.categoryID
                        ORDER BY c.categoryName, p.fullName";

               
                fputcsv($output, [
                    'Product ID',
                    'Model No',
                    'Product Name',
                    'Category',
                    'Stock Quantity',
                    'Price (£)',
                    'Monthly Sales',
                    'Description'
                ]);
        }

      
        $result = $conn->query($sql);

        if (!$result) {
            throw new Exception("Database query error: " . $conn->error);
        }

        while ($row = $result->fetch_assoc()) {
            $cleanRow = [];

            foreach ($row as $key => $value) {
                if (is_numeric($value) && in_array($key, ['Price', 'avg_price', 'revenue'])) {
                    $value = number_format((float) $value, 2);
                }

                if ($value === null) {
                    $value = 'N/A';
                }

                if (is_string($value)) {
                    $value = str_replace(["\r", "\n", "\t"], ' ', $value);

                    if (strlen($value) > 0 && in_array($value[0], ['=', '+', '-', '@'])) {
                        $value = "'" . $value;
                    }
                }

                $cleanRow[] = $value;
            }

            fputcsv($output, $cleanRow);
        }

    } catch (Exception $e) {
        error_log("Report generation error: " . $e->getMessage());

        fputcsv($output, ['Error generating report']);
        fputcsv($output, [$e->getMessage()]);
    }

    fclose($output);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Inventory Report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --danger-color: #ff4d6d;
            --light-color: #f8f9fa;
            --dark-color: #212529;
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
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        h1 {
            margin-bottom: 20px;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        p {
            margin-bottom: 20px;
            color: #6c757d;
        }

        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
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

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .card {
            border: 1px solid #e1e1e1;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: var(--dark-color);
            font-weight: 600;
        }

        .card-description {
            color: #6c757d;
            margin-bottom: 15px;
        }

        .format-selector {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .format-options {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .format-option {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .format-option input {
            margin: 0;
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><i class="fas fa-file-export"></i> Generate Inventory Report</h1>

        <p>Select the type of report you want to generate and download. Each report provides different insights into
            your inventory status.</p>

        <div class="card">
            <div class="card-title"><i class="fas fa-file-alt"></i> Full Inventory Report</div>
            <div class="card-description">
                Comprehensive overview of all products in your inventory, including stock levels, prices, and recent
                sales activity.
            </div>
            <a href="?type=full&format=csv" class="btn btn-primary">
                <i class="fas fa-download"></i> Generate Full Report
            </a>
        </div>

        <div class="card">
            <div class="card-title"><i class="fas fa-exclamation-triangle"></i> Low Stock Report</div>
            <div class="card-description">
                Lists all products with stock levels below the threshold (10 units), helping you identify items that
                need restocking.
            </div>
            <a href="?type=low_stock&format=csv" class="btn btn-primary">
                <i class="fas fa-download"></i> Generate Low Stock Report
            </a>
        </div>

        <div class="card">
            <div class="card-title"><i class="fas fa-chart-line"></i> Sales Report</div>
            <div class="card-description">
                Details of product sales for the last 30 days, including units sold, revenue, and current stock levels.
            </div>
            <a href="?type=sales&format=csv" class="btn btn-primary">
                <i class="fas fa-download"></i> Generate Sales Report
            </a>
        </div>

        <div class="card">
            <div class="card-title"><i class="fas fa-tags"></i> Category Report</div>
            <div class="card-description">
                Summary of your inventory organized by product categories, showing product counts, average prices, and
                stock status.
            </div>
            <a href="?type=category&format=csv" class="btn btn-primary">
                <i class="fas fa-download"></i> Generate Category Report
            </a>
        </div>

        <div class="format-selector">
            <p><strong>Download Format:</strong></p>
            <div class="format-options">
                <label class="format-option">
                    <input type="radio" name="format" value="csv" checked onclick="updateReportLinks('csv')"> CSV
                </label>
                <label class="format-option">
                    <input type="radio" name="format" value="excel" onclick="updateReportLinks('excel')"> Excel
                </label>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <a href="inventory_dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <script>
        function updateReportLinks(format) {
            const reportLinks = document.querySelectorAll('.card .btn-primary');
            reportLinks.forEach(link => {
                const url = new URL(link.href, window.location.origin);
                const type = url.searchParams.get('type');

                link.href = `?type=${type}&format=${format}`;
            });
        }
    </script>
</body>

</html>
