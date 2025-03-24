<?php
require_once("dbconnection.php");
ob_start();
include 'header.php';

if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['customerID'];
$sql = $conn->prepare("SELECT orderID, totalPrice FROM Orders WHERE customerID = ?");
$sql->bind_param("i", $customerID);
$sql->execute();
$orderResult = $sql->get_result();
?>

<div class="history-header">
	<h1>Returns History</h1>
</div>

<?php
if ($orderResult->num_rows > 0) {	
	while($orderRow = $orderResult->fetch_assoc()){
    	$totalPrice = $orderRow['totalPrice'];
		$sql = $conn->prepare("SELECT returnReason, returnReasonExplanation FROM Returns  WHERE orderID = ?");
    	$sql->bind_param("i", $orderRow['orderID']);
        $sql->execute();
        $returnResult = $sql->get_result();
        if ($returnResult->num_rows >0){
        	$returns = true;
        	while($returnRow = $returnResult->fetch_assoc()){
            	$returnReason = $returnRow['returnReason']; 
                $returnReasonExplanation = $returnRow['returnReasonExplanation'];
            	$sql = $conn->prepare("SELECT productID, Quantity, itemPrice FROM OrderItem WHERE orderID = ?");
				$sql->bind_param("i", $orderRow['orderID']);
				$sql->execute();
				$productResult = $sql->get_result();
            	if ($productResult->num_rows >0){
                	while ($productRow = $productResult->fetch_assoc()){
                		$quantity = $productRow['Quantity'];
						$itemPrice = $productRow['itemPrice'];
                		$stmt = $conn->prepare("SELECT fullName, imgURL, stockQuantity FROM Products WHERE productID = ?");
						$stmt->bind_param("i", $productRow['productID']);
						$stmt->execute();
						$productDetailResult = $stmt->get_result();
            			if ($productDetailResult->num_rows > 0) {
		    				$productDetailRow = $productDetailResult->fetch_assoc();
		    				$fullName = $productDetailRow['fullName'];
		    				$imgURL = $productDetailRow['imgURL'];
                    
							echo "<div class='product-container'>";
							echo "<div class='product-details'>";
							echo "<p><strong>Product:</strong> " . $fullName . "</p>";
							echo "<p><strong>Quantity:</strong> " . $quantity . "</p>";
							echo "<p><strong>Price:</strong> $" . $itemPrice . "</p>";
							echo "<img src='" . $imgURL . "' alt='Product Image'>";
							echo "</div>";
                        }
                    }
                }
            	echo "<div class='return-details'>";
				echo "<p><strong>Return Reason:</strong> " . $returnReason . "</p>";
				echo "<p><strong>Return Explanation:</strong> " . $returnReasonExplanation . "</p>";
				echo "<p class='total-price'><strong>Total: £</strong>" . $totalPrice . "</p>";
				echo "</div>";
				echo "</div>";
            }
        } 
	}
}

if (!$returns){
?>
    <div class="empty-returns">
        <h2>No Returns Yet</h2>
        <p>Looks like you haven't returned any items.</p>
    </div>
<?php
}

include 'footer.php'; 
ob_end_flush();
?>

<style>
.product-container {
    max-width: 1750px;
    margin: 30px auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.product-details {
    background-color: #fff;
    padding: 15px;
    margin: 15px 0;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.product-details img {
    display: block;
    max-width: 200px;
    height: auto;
    margin: 10px auto;
    border-radius: 6px;
    border: 1px solid #ddd;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

.product-details p {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 10px 0;
}

.return-details {
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.return-details p {
    font-size: 16px;
    font-weight: 500;
    color: #444;
    margin: 10px 0;
}

.total-price {
    font-size: 20px;
    font-weight: bold;
    color: #ff4d4d;
    margin-top: 15px;
}

.history-container {
	max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
}
    
.history-header {
	margin-bottom: 30px;
}
    
.history-header h1 {
	color: #0078d7;
    margin-bottom: 10px;
}

.empty-returns {
	text-align: center;
    padding: 50px 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
    
.empty-returns h2 {
	color: #333;
    margin-bottom: 15px;
}
    
.empty-returns p {
	color: #666;
    margin-bottom: 20px;
}

</style>