<?php


$suggestions = ['apple', 'banana', 'grape', 'orange', 'watermelon', 'mango'];
echo "myFunc(".$suggestions[0].")";

/*
require_once 'DBconnect.php';

try {
    $searchMessage = json_decode(file_get_contents("php://input"), true);
    if (isset($searchMessage["message"])) {
        $message = $searchMessage["message"];
        if (strlen($message) <= 1) {
            $products = "SELECT * FROM products WHERE fullName LIKE '$message%'";
            $productsResult = $conn->query($products);
        } else{
            $products = "SELECT * FROM products WHERE fullName LIKE '%$message%'";
            $productsResult = $conn->query($products);
        }
        echo json_encode([$productsResult]);
    } else {
        throw new exception("Empty or Invalid message");
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
mysqli_close($conn);
*/
?>