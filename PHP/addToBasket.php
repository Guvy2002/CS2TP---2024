<?php
$conn = mysqli_connect("localhost", "cs2team8", "ZAUzatil5V99EcF", "cs2team8_db");

if (!$conn) {
    die("Database Failed to Connect: " . mysqli_connect_error());
}

// Get the JSON input from JavaScript
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['id'], $data['name'], $data['price'])) {
        throw new Exception("Invalid input data");
    }

    $productID = $data['id']; // Assuming 'id' maps to the productID
    $productName = $data['name'];
    $productPrice = $data['price'];

    // Check if the customer is logged in
    if (!isset($_COOKIE["customerID"])) {
        throw new Exception("Not logged in");
    }

    $customerID = $_COOKIE["customerID"];

    // Check if the customer has an existing basket
    $basketQuery = $conn->prepare("SELECT basketID FROM Basket WHERE customerID = ?");
    $basketQuery->bind_param("i", $customerID);
    $basketQuery->execute();
    $basketResult = $basketQuery->get_result();

    $basketID = null;

    if ($basketResult->num_rows > 0) {
        $basketRow = $basketResult->fetch_assoc();
        $basketID = $basketRow['basketID'];
    } else {
        // create basket if there isn't one
        $createBasketQuery = $conn->prepare("INSERT INTO Basket (customerID) VALUES (?)");
        $createBasketQuery->bind_param("i", $customerID);
        $createBasketQuery->execute();
        $basketID = $createBasketQuery->insert_id;
        $createBasketQuery->close();
    }

    // Add  product to BasketItems table
    $addItemQuery = $conn->prepare(
        "INSERT INTO BasketItems (basketID, productID, quantity) VALUES (?, ?, 1) 
        ON DUPLICATE KEY UPDATE quantity = quantity + 1"
    );
    $addItemQuery->bind_param("ii", $basketID, $productID);
    $addItemQuery->execute();
    $addItemQuery->close();

    echo json_encode(["status" => "success", "message" => "Item has been added to basket"]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    // Close the database connection
    mysqli_close($conn);
}
