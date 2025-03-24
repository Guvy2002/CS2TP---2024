<?php
require_once('dbconnection.php'); 
session_start();


$data = json_decode(file_get_contents("php://input"), true);
$productID = $data['productID'];
$quantity = $data['quantity'];


if (!isset($_SESSION['customerID'])) {
    echo json_encode(["status" => "error", "message" => "Please log in to update the basket."]);
    exit;
}

if (!$productID || !$quantity) {
    echo json_encode(["status" => "error", "message" => "Product ID or quantity is missing."]);
    exit;
}


try {
    $customerID = $_SESSION['customerID'];


    $stmt = $conn->prepare("SELECT basketID FROM Basket WHERE customerID = ? ORDER BY createdDate DESC LIMIT 1");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(["status" => "error", "message" => "Basket not found."]);
        exit;
    }

    $basket = $result->fetch_assoc();
    $basketID = $basket['basketID'];


    $stmt = $conn->prepare("UPDATE BasketItem SET Quantity = ? WHERE basketID = ? AND productID = ?");
    $stmt->bind_param("iii", $quantity, $basketID, $productID);
    $stmt->execute();

    echo json_encode(["status" => "success", "message" => "Quantity updated successfully."]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>