<?php
require_once('dbconnection.php');
session_start();
try {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($_SESSION['customerID'])) {
        throw new Exception("Please log in to add items to the basket.");
    }
    $productID = $data['id'];
    if (!$productID) {
        throw new Exception("Product ID is missing.");
    }
    $customerID = $_SESSION['customerID'];
    $date = date("Y-m-d");
    $quantity = isset($data['quantity']) ? intval($data['quantity']) : 1;
    $prodStmt = $conn->prepare("SELECT fullName, imgURL, stockQuantity FROM Products WHERE productID = ?");
    $prodStmt->bind_param("i", $productID);
    $prodStmt->execute();
    $prodResult = $prodStmt->get_result();
    $productInfo = $prodResult->fetch_assoc();
    
    $productName = $productInfo['fullName'];
    $productImage = $productInfo['imgURL'];
    $stockQuantity = $productInfo['stockQuantity'];

    if ($stockQuantity <= 0) {
        throw new Exception("This product is out of stock.");
    }
    
    $stmt = $conn->prepare("SELECT basketID FROM Basket WHERE customerID = ? ORDER BY createdDate DESC LIMIT 1");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO Basket (customerID, createdDate) VALUES (?, ?)");
        $stmt->bind_param("is", $customerID, $date);
        $stmt->execute();
        $basketID = $conn->insert_id;
    } else {
        $basket = $result->fetch_assoc();
        $basketID = $basket['basketID'];
    }
    
    $stmt = $conn->prepare("SELECT basketItemID, Quantity FROM BasketItem WHERE basketID = ? AND productID = ?");
    $stmt->bind_param("ii", $basketID, $productID);
    $stmt->execute();
    $existingItem = $stmt->get_result();
    
    if ($existingItem->num_rows > 0) {
        $item = $existingItem->fetch_assoc();
        $currentQuantity = $item['Quantity'];
        $requestedNewQuantity = $currentQuantity + $quantity;

        if ($requestedNewQuantity > $stockQuantity) {
            if ($currentQuantity == $stockQuantity) {
                throw new Exception("You already have the maximum available quantity in your basket.");
            }
            $newQuantity = $stockQuantity;
            $message = "Only {$stockQuantity} items are available. Your basket has been updated to the maximum available quantity.";
        } else {
            $newQuantity = $requestedNewQuantity;
            $message = "Item quantity updated in your basket.";
        }
        
        $itemID = $item['basketItemID'];
        $stmt = $conn->prepare("UPDATE BasketItem SET Quantity = ? WHERE basketItemID = ?");
        $stmt->bind_param("ii", $newQuantity, $itemID);
        $stmt->execute();
        
        echo json_encode([
            "status" => "success", 
            "message" => $message,
            "quantity" => $newQuantity,
            "productName" => $productName,
            "productImage" => $productImage
        ]);
    } else {
        if ($quantity > $stockQuantity) {
            $quantity = $stockQuantity;
            $message = "Only {$stockQuantity} items are available. Added the maximum available quantity to your basket.";
        } else {
            $message = "Item has been added to the basket.";
        }
        
        $stmt = $conn->prepare("INSERT INTO BasketItem (basketID, productID, Quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $basketID, $productID, $quantity);
        $stmt->execute();
        
        echo json_encode([
            "status" => "success", 
            "message" => $message,
            "productName" => $productName,
            "productImage" => $productImage
        ]);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
