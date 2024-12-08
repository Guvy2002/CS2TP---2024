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

    $sql = $conn->prepare("INSERT INTO basket (id, name, price) VALUES (?, ?, ?)");
    $sql->bind_param("s",$id);
    $sql->execute();

    //$sql2 = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    //$sql2->bind_param("s",$id);
    //$sql2->execute();
    echo json_encode(["status" => "complete", "message" => "Item has been added to basket"]);

}catch(exception $e){
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

?>
