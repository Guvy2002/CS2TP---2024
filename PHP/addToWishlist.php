<?php
require_once('dbconnection.php');
session_start();
try {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($_SESSION['customerID'])) {
        throw new Exception("Please log in to add items to the wishlist.");
    }
    $productID = $data['id'];
    if (!$productID) {
        throw new Exception("Product ID is missing.");
    }
    
    
    $prodStmt = $conn->prepare("SELECT fullName, imgURL FROM Products WHERE productID = ?");
    $prodStmt->bind_param("i", $productID);
    $prodStmt->execute();
    $prodResult = $prodStmt->get_result();
    $productInfo = $prodResult->fetch_assoc();
    $productName = $productInfo['fullName'];
    $productImage = $productInfo['imgURL'];
    
    $customerID = $_SESSION['customerID'];
    $date = date("Y-m-d");
    
    
    $stmt = $conn->prepare("SELECT wishlistID FROM Wishlist WHERE customerID = ? LIMIT 1");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        
        $stmt = $conn->prepare("INSERT INTO Wishlist (customerID, createdDate) VALUES (?, ?)");
        $stmt->bind_param("is", $customerID, $date);
        $stmt->execute();
        $wishlistID = $conn->insert_id;
    } else {
        $wishlist = $result->fetch_assoc();
        $wishlistID = $wishlist['wishlistID'];
    }
    
    
    $stmt = $conn->prepare("SELECT wishlistItemID FROM WishlistItem WHERE wishlistID = ? AND productID = ?");
    $stmt->bind_param("ii", $wishlistID, $productID);
    $stmt->execute();
    $existingItem = $stmt->get_result();
    
    if ($existingItem->num_rows > 0) {
        
        echo json_encode([
            "status" => "success", 
            "message" => "This item is already in your wishlist.",
            "productName" => $productName,
            "productImage" => $productImage,
            "alreadyExists" => true
        ]);
    } else {
        
        $stmt = $conn->prepare("INSERT INTO WishlistItem (wishlistID, productID, Quantity) VALUES (?, ?, 1)");
        $stmt->bind_param("ii", $wishlistID, $productID);
        $stmt->execute();
        
        echo json_encode([
            "status" => "success", 
            "message" => "Item has been added to your wishlist.",
            "productName" => $productName,
            "productImage" => $productImage,
            "alreadyExists" => false
        ]);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>