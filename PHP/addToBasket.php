<?php
require_once('dbconnection.php');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($_COOKIE['customerID'])) {
        throw new Exception("Please log in to add items to the basket.");
    }
    $productID = $data['id'];
    if (!$productID) {
        throw new Exception("Product ID is missing.");
    }
    $customerID = $_COOKIE['customerID'];
    $date = date("Y-m-d");
    $quantity = 1;
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
    $stmt = $conn->prepare("INSERT INTO BasketItem (basketID, productID, Quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $basketID, $productID, $quantity);
    $stmt->execute();
    echo json_encode(["status" => "success", "message" => "Item has been added to the basket."]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
