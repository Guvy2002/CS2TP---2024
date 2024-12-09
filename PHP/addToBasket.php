<?php
require_once('DBconnection.php');

// Get the JSON input from JavaScript
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['id'], $data['name'], $data['price'])) {
        throw new Exception("Invalid input data");
    }

    $productID = $data['id']; // Assuming 'id' maps to the productID
    $productName = $data['name'];
    $productPrice = $data['price'];
    $customerID = $_COOKIE['customerID'];
    $date = date("y-m-d");
    $quantity = 1;

    $stmt = $conn->prepare("INSERT INTO Basket (customerID, createdDate) VALUES (?,?)");
    $stmt->bind_param("ss", $customerID, $date);
    $basketIDs = "SELECT basketId, productID FROM Basket";
    $ordersIDsResult = mysqli_query->query($conn, $basketIDs);
    if (mysqli_num_rows($ordersIDsResult) > 0) {
        while ($row = mysqli_fetch_assoc($ordersIDsResult)) {
            if ($productID == $row['productID']) {
                $basketID = $row['basketId'];
            }
        }
    }
    $stmt = $conn->prepare("INSERT INTO BasketItem (basketID, productID, Quantity) VALUES (?,?,?)");
    $stmt->bind_param("sss", $basketID, $productID, $quantity);


    echo json_encode(["status" => "success", "message" => "Item has been added to basket"]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
mysqli_close($conn);