<?php
require_once('dbconnection.php');
session_start();

try {
    if (!isset($_SESSION['customerID'])) {
        throw new Exception("Please log in to update your basket.");
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    $productId = isset($data['id']) ? intval($data['id']) : 0;
    $quantity = isset($data['quantity']) ? intval($data['quantity']) : 0;
    
    if (!$productId || $quantity < 1) {
        throw new Exception("Invalid parameters");
    }
    
    $customerID = $_SESSION['customerID'];

    $stmt = $conn->prepare("SELECT stockQuantity FROM Products WHERE productID = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Product not found");
    }
    
    $product = $result->fetch_assoc();
    $stockQuantity = $product['stockQuantity'];

    if ($quantity > $stockQuantity) {
        $quantity = $stockQuantity;
    }

    $stmt = $conn->prepare("SELECT b.basketID FROM Basket b WHERE b.customerID = ? ORDER BY b.createdDate DESC LIMIT 1");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Basket not found");
    }
    
    $basket = $result->fetch_assoc();
    $basketID = $basket['basketID'];
    
    $stmt = $conn->prepare("UPDATE BasketItem SET Quantity = ? WHERE basketID = ? AND productID = ?");
    $stmt->bind_param("iii", $quantity, $basketID, $productId);
    $stmt->execute();
    
    echo json_encode([
        "status" => "success",
        "message" => "Basket updated successfully"
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?> 