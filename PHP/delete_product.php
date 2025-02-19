<?php
session_start();
require_once("dbconnection.php");

// Check if user is admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    $_SESSION['error_message'] = "Unauthorized access";
    header('Location: inventory_dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Check if product exists
        $checkSql = "SELECT productID, fullName FROM Products WHERE productID = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("i", $productId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("Product not found");
        }
        
        $product = $result->fetch_assoc();
        
        // Delete related records first (foreign key constraints)
        $relatedTables = ['BasketItem', 'OrderItem', 'WishlistItem'];
        
        foreach ($relatedTables as $table) {
            $sql = "DELETE FROM $table WHERE productID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->close();
        }
        
        // Finally delete the product
        $sql = "DELETE FROM Products WHERE productID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        $_SESSION['success_message'] = "Product '" . htmlspecialchars($product['fullName']) . "' has been deleted successfully";
        
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        $_SESSION['error_message'] = "Error deleting product: " . $e->getMessage();
    }
    
} else {
    $_SESSION['error_message'] = "Invalid request";
}

// Redirect back to dashboard
header('Location: inventory_dashboard.php');
exit();