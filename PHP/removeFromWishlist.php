<?php
require_once('dbconnection.php');
session_start();
try {
    $data = json_decode(file_get_contents("php://input"), true);
    $productID = $data['id'];
    if (!$productID) {
        throw new Exception("Product ID is missing.");
    }
    $customerID = $_SESSION['customerID'];
    $stmt = $conn->prepare("SELECT wishlistID FROM Wishlist WHERE customerID = ?");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    $wishlist = $result->fetch_assoc();
    $wishlistID = $wishlist['wishlistID'];

    $stmt = $conn->prepare("SELECT wishlistItemID FROM WishlistItem WHERE wishlistID = ? AND productID = ?");
    $stmt->bind_param("ii", $wishlistID, $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    $wishlistItem = $result->fetch_assoc();
    if (!$wishlistItem) {
        throw new Exception("Wishlist item not found");
    }
    $wishlistItemID = $wishlistItem['wishlistItemID'];
    $stmt = $conn->prepare("DELETE FROM WishlistItem WHERE wishlistItemID = ?");
    $stmt->bind_param("i", $wishlistItemID);
    $stmt->execute();
    echo json_encode(["status" => "success", "message" => "Item has been removed from the wishlist."]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>