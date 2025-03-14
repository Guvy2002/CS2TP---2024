<?php
session_start();
require_once("dbconnection.php");

//security check for admin
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    $conn->begin_transaction();
    
    try {
        $checkSql = "SELECT productID, fullName FROM Products WHERE productID = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("i", $productId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("Product not found");
        }
        
        $product = $result->fetch_assoc();
        
        $relatedTables = ['BasketItem', 'OrderItem', 'WishlistItem'];
        
        foreach ($relatedTables as $table) {
            $sql = "DELETE FROM $table WHERE productID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->close();
        }
        
        $sql = "DELETE FROM Products WHERE productID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        $conn->commit();
        
        $_SESSION['success_message'] = "Product '" . htmlspecialchars($product['fullName']) . "' has been deleted successfully";
        
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = "Error deleting product: " . $e->getMessage();
    }
    
} else {
    $_SESSION['error_message'] = "Invalid request";
}

header('Location: inventory_dashboard.php');
exit();
