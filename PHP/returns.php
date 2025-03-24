<?php
ob_start();
require_once("dbconnection.php");
include 'header.php';

$success_message = '';
$total = 0;

if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

$orderID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$orderID) {
    header("Location: myaccount.php");
    exit();
}


if (isset($_POST["submitReturn"])) {
        try {
        	$customerID = $_SESSION['customerID'];
        	$pendingMessage = 'Pending';
        	$returnMessage = 'Returned';
 			$returnReason = $_POST['returnReason'];       
        	$returnReasonExplanation = $_POST['returnTextReason']; 
        	$date = date('Y-m-d');
        	
            $stmt = $conn->prepare("INSERT INTO OrderHistory (customerID, orderID, Action, ActionDate) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $customerID, $orderID, $returnMessage, $date);
            if ($stmt->execute()) {
            	$stmt = $conn->prepare("UPDATE Orders SET orderStatus = ? WHERE orderID = ?");
            	$stmt->bind_param("si", $pendingMessage,$orderID);
            	if ($stmt->execute()) {
                	$stmt = $conn->prepare("INSERT INTO Returns (orderID, returnReason, returnReasonExplanation) VALUES (?, ?, ?)");
                	$stmt->bind_param("iss", $orderID, $returnReason, $returnReasonExplanation);
                	if ($stmt-> execute()) {
                    	$sql = $conn->prepare("SELECT productID, Quantity FROM OrderItem WHERE orderID = ?");
						$sql->bind_param("i", $orderID);
						$sql->execute();
						$orderResults = $sql->get_result();
						if ($orderResults->num_rows > 0) {	
                        	$allProductsUpdated = true;
							while($orderRows = $orderResults->fetch_assoc()){
    							$productID = $orderRows['productID'];
								$quantity = $orderRows['Quantity'];
								$stmt = $conn->prepare("SELECT stockQuantity FROM Products WHERE productID = ?");
								$stmt->bind_param("i", $productID);
								$stmt->execute();
								$productResults = $stmt->get_result();
								if ($productResults->num_rows > 0) {
	    							$productRows = $productResults->fetch_assoc();
	    							$stockQuantity = $productRows['stockQuantity'];
                                	$realQuantity = $stockQuantity + $quantity;
                                	$stmt = $conn->prepare("UPDATE Products SET stockQuantity = ? WHERE productID = ?");
            						$stmt->bind_param("ii", $realQuantity,$productID);
            						$stmt->execute();
								} else {
                                	$allProductsUpdated = false;
                    				$error_message = "Error submitting return. Please try again.";
                                }
                            }
                        	if ($allProductsUpdated) {
                        		$success_message = "Your return has been submitted.";
                       			header("Location: sendEmail.php?contents=returns&redirect=".urlencode("/myaccount.php"));
            					exit();
                            }
						} else {
                    		$error_message = "Error submitting return. Please try again.";
                        }		
                    } else {
                    	$error_message = "Error submitting return. Please try again.";
                    }
                } else {
                	$error_message = "Error submitting return. Please try again.";
                }
            } else {
                $error_message = "Error submitting return. Please try again.";
            }
        } catch (Exception $ex) {
            $error_message = "Error: " . $ex->getMessage();
        }
}

$sql = $conn->prepare("SELECT productID, Quantity, itemPrice FROM OrderItem WHERE orderID = ?");
$sql->bind_param("i", $orderID);
$sql->execute();
$orderResult = $sql->get_result();

if ($orderResult->num_rows > 0) {	
	while($orderRow = $orderResult->fetch_assoc()){
    	$productID = $orderRow['productID'];
		$quantity = $orderRow['Quantity'];
		$itemPrice = $orderRow['itemPrice'];
    	$total = $total + ($itemPrice * $quantity);

		$stmt = $conn->prepare("SELECT fullName, imgURL, stockQuantity FROM Products WHERE productID = ?");
		$stmt->bind_param("i", $productID);
		$stmt->execute();
		$productResult = $stmt->get_result();
		if ($productResult->num_rows > 0) {
	    	$productRow = $productResult->fetch_assoc();
	    	$fullName = $productRow['fullName'];
	    	$imgURL = $productRow['imgURL'];
	    	$stockQuantity = $productRow['stockQuantity'];
        
        	echo "<div class='product-details'>";
            echo "<p><strong>Product:</strong> " . $fullName . "</p>";
            echo "<p><strong>Quantity:</strong> " . $quantity . "</p>";
            echo "<p><strong>Price:</strong> $" . $itemPrice . "</p>";
            echo "<img src='" . $imgURL . "' alt='Product Image'>";
        	echo "</div>";
        
		}
    }
	echo "<p>Total Price: £" . $total . "</p>";
}


?>



<form id="returnForm" method="POST" action="">
	<input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
	<?php if (!empty($error_message)): ?>
		<div class="alert alert-danger">
    		<?php echo $error_message; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($success_message)): ?>
		<div class="alert alert-success">
	    	<?php echo $success_message; ?>
	    </div>
	<?php endif; ?>
    <select id="returnReason" name="returnReason">
        <option value="unwanted">Unwanted</option>
        <option value="broken">Broken</option>
        <option value="notAsExpected">Not as expected</option>
        <option value="wrongItemSent">Wrong item sent</option>
    	<option value="lateDelivery">Late delivery</option>
    	<option value="unwantedGift">Unwanted gift</option>
    </select>
    <textarea id="returnTextReason" name="returnTextReason" rows="5" placeholder="Please explain further..."></textarea>
    <button type="submit" name="submitReturn" class="submit-btn">Return order</button>
</form>


<?php
include 'footer.php';
ob_end_flush();
?>

<style>
#returnForm {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    text-align: center;
}

#returnForm .alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.submit-btn {
    display: inline-block;
    width: 100%;
    padding: 12px;
    background-color: #ff4d4d;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.submit-btn:hover {
    background-color: #cc0000;
}

p {
    font-size: 16px;
    color: #333;
    margin: 10px 0;
    text-align: center;
}

img {
    display: block;
    max-width: 200px;
    height: auto;
    margin: 10px auto;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.product-details {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 15px auto;
    max-width: 600px;
    text-align: center;
}

.product-details p {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 10px 0;
}

.product-details img {
    display: block;
    max-width: 180px;
    height: auto;
    margin: 10px auto;
    border-radius: 6px;
    border: 2px solid #ddd;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

#returnTextReason {
    width: 100%;
    max-width: 100%;
    min-width: 100%;
    height: 120px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    color: #333;
    background-color: #fff;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease-in-out;
}

#returnReason {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    color: #333;
    cursor: pointer;
    transition: border-color 0.3s ease-in-out;
}
</style>