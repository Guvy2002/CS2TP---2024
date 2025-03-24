<?php
session_start();
require_once("dbconnection.php");

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_POST['delete_product']) && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    
    $conn->begin_transaction();
    
    try {
        $tables = ['BasketItem', 'OrderItem', 'WishlistItem'];
        foreach ($tables as $table) {
            $stmt = $conn->prepare("DELETE FROM $table WHERE productID = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
        }
        
        $stmt = $conn->prepare("DELETE FROM Products WHERE productID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        $conn->commit();
        $_SESSION['success_message'] = "Product deleted successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = "Error deleting product: " . $e->getMessage();
    }
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$itemsPerPage = isset($_GET['entries']) ? max(10, min(50, intval($_GET['entries']))) : 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

$whereClause = "1=1";
$params = [];
$types = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
    $whereClause .= " AND p.fullName LIKE ?";
    $params[] = "%{$searchTerm}%";
    $types .= "s";
}

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = trim($_GET['category']);
    $whereClause .= " AND c.categoryName = ?";
    $params[] = $category;
    $types .= "s";
}

if (isset($_GET['stock_filter']) && !empty($_GET['stock_filter'])) {
    switch ($_GET['stock_filter']) {
        case 'low':
            $whereClause .= " AND p.stockQuantity < 10 AND p.stockQuantity > 0";
            break;
        case 'out':
            $whereClause .= " AND p.stockQuantity = 0";
            break;
        case 'good':
            $whereClause .= " AND p.stockQuantity >= 10";
            break;
    }
}

$countSql = "SELECT COUNT(*) as total 
             FROM Products p
             LEFT JOIN Category c ON p.categoryID = c.categoryID
             WHERE $whereClause";

if (!empty($params)) {
    $stmt = $conn->prepare($countSql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $countResult = $stmt->get_result();
    $totalProducts = $countResult->fetch_assoc()['total'];
} else {
    $countResult = $conn->query($countSql);
    $totalProducts = $countResult->fetch_assoc()['total'];
}

$totalPages = ceil($totalProducts / $itemsPerPage);

$currentPage = max(1, min($currentPage, max(1, $totalPages)));

$sql = "SELECT p.productID, p.ModelNo, p.fullName, p.Description, p.stockQuantity, p.Price, 
        c.categoryName, 
        (SELECT COUNT(*) FROM OrderItem oi 
         JOIN Orders o ON oi.orderID = o.orderID 
         WHERE oi.productID = p.productID 
         AND o.orderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as monthly_sales
        FROM Products p
        LEFT JOIN Category c ON p.categoryID = c.categoryID
        WHERE $whereClause
        ORDER BY p.productID
        LIMIT ? OFFSET ?";

$params[] = $itemsPerPage;
$types .= "i";
$params[] = $offset;
$types .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

$lowStockSql = "SELECT COUNT(*) as count FROM Products WHERE stockQuantity < 10 AND stockQuantity > 0";
$lowStockResult = $conn->query($lowStockSql);
$lowStockCount = $lowStockResult->fetch_assoc()['count'];

$outOfStockSql = "SELECT COUNT(*) as count FROM Products WHERE stockQuantity = 0";
$outOfStockResult = $conn->query($outOfStockSql);
$outOfStockCount = $outOfStockResult->fetch_assoc()['count'];

$categorySql = "SELECT c.categoryName, 
                COUNT(p.productID) as productCount, 
                AVG(p.stockQuantity) as avgStock,
                SUM(CASE WHEN p.stockQuantity < 10 THEN 1 ELSE 0 END) as lowStockCount
                FROM Category c
                LEFT JOIN Products p ON c.categoryID = p.categoryID 
                GROUP BY c.categoryID
                ORDER BY c.categoryName";
$categoryResult = $conn->query($categorySql);
$categories = $categoryResult->fetch_all(MYSQLI_ASSOC);

function buildQueryParams($page, $entries, $extraParams = []) {
    $params = array_merge([
        'page' => $page,
        'entries' => $entries
    ], $extraParams);
    
    return http_build_query($params);
}

$currentFilters = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $currentFilters['search'] = $_GET['search'];
}
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $currentFilters['category'] = $_GET['category'];
}
if (isset($_GET['stock_filter']) && !empty($_GET['stock_filter'])) {
    $currentFilters['stock_filter'] = $_GET['stock_filter'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-container" id="adminContainer">
        <?php 
        $_GET['page'] = 'inventory'; 
		include 'admin_sidebar.php';
		?>
        <div class="main-content">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <h1><i class="fas fa-chart-line"></i> Inventory Dashboard</h1>
                    <div class="admin-controls">
                        <a href="add_product.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                        <a href="generate_report.php" class="btn btn-primary">
                            <i class="fas fa-file-export"></i> Export Report
                        </a>
                    </div>
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
                            placeholder="Search products..." 
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <select name="category" class="filter-box">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['categoryName']); ?>"
                                    <?php echo (isset($_GET['category']) && $_GET['category'] === $category['categoryName']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['categoryName']); ?>
                                (<?php echo (int)$category['productCount']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <select name="stock_filter" class="filter-box">
                        <option value="">All Stock Levels</option>
                        <option value="low" <?php echo (isset($_GET['stock_filter']) && $_GET['stock_filter'] === 'low') ? 'selected' : ''; ?>>
                            Low Stock
                        </option>
                        <option value="out" <?php echo (isset($_GET['stock_filter']) && $_GET['stock_filter'] === 'out') ? 'selected' : ''; ?>>
                            Out of Stock
                        </option>
                        <option value="good" <?php echo (isset($_GET['stock_filter']) && $_GET['stock_filter'] === 'good') ? 'selected' : ''; ?>>
                            In Stock
                        </option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <?php if (!empty($currentFilters)): ?>
                        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="btn btn-secondary">Clear Filters</a>
                    <?php endif; ?>
                </form>

                <?php if ($lowStockCount > 0): ?>
                    <div class="alert-card">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <h3>Low Stock Alert</h3>
                            <p><?php echo $lowStockCount; ?> products need attention</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-box fa-2x"></i>
                        <h3>Total Products</h3>
                        <p><?php echo $totalProducts; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                        <h3>Low Stock Items</h3>
                        <p><?php echo $lowStockCount; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-times-circle fa-2x"></i>
                        <h3>Out of Stock</h3>
                        <p><?php echo $outOfStockCount; ?></p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-tags fa-2x"></i>
                        <h3>Categories</h3>
                        <p><?php echo count($categories); ?></p>
                    </div>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2><i class="fas fa-list"></i> Inventory List</h2>
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
                            <?php foreach ($currentFilters as $key => $value): ?>
                                <input type="hidden" name="<?php echo htmlspecialchars($key); ?>" 
                                    value="<?php echo htmlspecialchars($value); ?>">
                            <?php endforeach; ?>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Stock Level</th>
                                    <th>Price</th>
                                    <th>Monthly Sales</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($products) > 0): ?>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($product['productID']); ?></td>
                                            <td><?php echo htmlspecialchars($product['fullName']); ?></td>
                                            <td><?php echo htmlspecialchars($product['categoryName']); ?></td>
                                            <td>
                                                <span class="stock-status <?php
                                                echo $product['stockQuantity'] == 0 ? 'stock-out' :
                                                    ($product['stockQuantity'] < 10 ? 'stock-low' : 'stock-good');
                                                ?>">
                                                    <?php echo (int)$product['stockQuantity']; ?> units
                                                </span>
                                            </td>
                                            <td>£<?php echo number_format((float)$product['Price'], 2); ?></td>
                                            <td><?php echo (int)$product['monthly_sales']; ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="edit_product.php?id=<?php echo (int)$product['productID']; ?>" 
                                                    class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" class="delete-form">
                                                        <input type="hidden" name="product_id" 
                                                            value="<?php echo (int)$product['productID']; ?>">
                                                        <button type="submit" name="delete_product" 
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this product?');">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="no-results">No products found matching your criteria</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($totalProducts > 0): ?>
                        <div class="pagination">
                            <div class="pagination-info">
                                Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $itemsPerPage, $totalProducts); ?> of
                                <?php echo $totalProducts; ?> entries
                            </div>
                            <div class="pagination-controls">
                                <?php if ($totalPages > 1): ?>
                                    <?php if ($currentPage > 1): ?>
                                        <a href="?<?php echo buildQueryParams($currentPage - 1, $itemsPerPage, $currentFilters); ?>" class="btn">
                                            <i class="fas fa-chevron-left"></i> Previous
                                        </a>
                                    <?php endif; ?>

                                    <?php
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($totalPages, $currentPage + 2);
                                    
                                    if ($startPage > 1) {
                                        echo '<a href="?' . buildQueryParams(1, $itemsPerPage, $currentFilters) . '" class="btn">1</a>';
                                        if ($startPage > 2) {
                                            echo '<span class="ellipsis">...</span>';
                                        }
                                    }
                                    
                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        echo '<a href="?' . buildQueryParams($i, $itemsPerPage, $currentFilters) . '" 
                                            class="btn ' . ($i === $currentPage ? 'active' : '') . '">' . $i . '</a>';
                                    }
                                    
                                    if ($endPage < $totalPages) {
                                        if ($endPage < $totalPages - 1) {
                                            echo '<span class="ellipsis">...</span>';
                                        }
                                        echo '<a href="?' . buildQueryParams($totalPages, $itemsPerPage, $currentFilters) . '" class="btn">' . $totalPages . '</a>';
                                    }
                                    ?>

                                    <?php if ($currentPage < $totalPages): ?>
                                        <a href="?<?php echo buildQueryParams($currentPage + 1, $itemsPerPage, $currentFilters); ?>" class="btn">
                                            Next <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
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
    flex-wrap: wrap;
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

.filter-box {
    padding: 12px 15px;
    border: 1px solid #e1e1e1;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: var(--transition);
    min-width: 200px;
}

.filter-box:focus {
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

.alert-card {
    background-color: #fff1f2;
    border: 1px solid var(--danger-color);
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.alert-card i {
    font-size: 2rem;
    color: var(--danger-color);
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

.inventory-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.inventory-table th,
.inventory-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e1e1e1;
}

.inventory-table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: var(--dark-color);
}

.inventory-table tbody tr:hover {
    background-color: #f8f9fa;
}

.stock-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.stock-low {
    background-color: #fff1f2;
    color: var(--danger-color);
}

.stock-out {
    background-color: #fecaca;
    color: #dc2626;
}

.stock-good {
    background-color: #ecfdf5;
    color: #059669;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.delete-form {
    display: inline;
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

@media (max-width: 768px) {
    .search-filter-container {
        flex-direction: column;
        align-items: stretch;
    }

    .search-wrapper,
    .filter-box {
        width: 100%;
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
}

</style>
</html>