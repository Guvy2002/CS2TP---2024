//use the IDs of the items in Home Page.html to take to product out of inventory and added to basket
//if on a specific item page, that item is taen out of inventory and added to basket

//sql code to remove item from storage and send to basket table

<?php
$conn = mysqli_connect("cs2team8_db", "cs2team8", "ZAUzatil5V99EcF");

if(!$conn){
    die("Database Failed to Connect: " . mysqli_connect_error());
}
// Get the JSON input from JavaScript
try{
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data || !isset($data['id'], $data['name'], $data['price'])) {
        throw new Exception("Invalid input data");
    }
    $id = $data['id'];
    $name = $data['name'];
    $price = $data['price'];

    $basketIDs = "SELECT basketID, customerID FROM Basket";
    $product = "SELECT productID, imgURL, fullName, Price FROM Products";
    $basket = "SELECT basketID, productID, Quantity FROM BasketItems";
    $basketIDsResult = mysqli_query->query($conn, $basketIDs);
    if (isset($_COOKIE["customerID"])){
        $customerID = $_COOKIE["customerID"];
        if (mysqli_num_rows($basketIDsResult) > 0) {
            while ($row = mysqli_fetch_assoc($basketIDsResult)) {
                if ($row['customerID'] == $customerID) {
                    $basketID = $row['basketID'];
                }    
                $sql = $conn->prepare("INSERT INTO BasketItem (basketID, productID) VALUES ($basketID, $id)");
                $sql->bind_param("s",$id);
                $sql->execute();
            }
        }else{
            $message = 'Basket is empty';
        }
    }else{
        $message = 'Not Logged in';
    }
    //$sql2 = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    //$sql2->bind_param("s",$id);
    //$sql2->execute();
    echo json_encode(["status" => "complete", "message" => "Item has been added to basket"]);

}catch(exception $e){
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

?>
