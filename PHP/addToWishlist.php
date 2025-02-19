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
    $customerID = $_SESSION['customerID'];
    $date = date("Y-m-d");
    $quantity = 1;
    $stmt = $conn->prepare("SELECT wishlistID FROM Wishlist WHERE customerID = ? ORDER BY createdDate DESC LIMIT 1");
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
    $stmt = $conn->prepare("INSERT INTO WishlistItem (wishlistID, productID, Quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $wishlistID, $productID, $quantity);
    $stmt->execute();
    echo json_encode(["status" => "success", "message" => "Item has been added to the wishlist."]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>