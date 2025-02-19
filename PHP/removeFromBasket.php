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
    $stmt = $conn->prepare("SELECT basketID FROM Basket WHERE customerID = ?");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    $basket = $result->fetch_assoc();
    $basketID = $basket['basketID'];

    $stmt = $conn->prepare("SELECT basketItemID FROM BasketItem WHERE basketID = ? AND productID = ?");
    $stmt->bind_param("ii", $basketID, $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    $basketItem = $result->fetch_assoc();
    if (!$basketItem) {
        throw new Exception("Basket item not found");
    }
    $basketItemID = $basketItem['basketItemID'];
    $stmt = $conn->prepare("DELETE FROM BasketItem WHERE basketItemID = ?");
    $stmt->bind_param("i", $basketItemID);
    $stmt->execute();
    echo json_encode(["status" => "success", "message" => "Item has been removed from the basket."]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>