<?php


$mail->Subject = 'Order Confirmation';
$orderID = isset($_GET['orderID']) ? intval($_GET['orderID']) : null;

if (!$orderID) {
    die("Order ID not provided");
}

$orderQuery = $conn->prepare("
    SELECT o.*, p.paymentMethod 
    FROM Orders o
    LEFT JOIN Payment p ON o.paymentID = p.paymentID
    WHERE o.orderID = ? AND o.customerID = ?
");
$orderQuery->bind_param("ii", $orderID, $customerID);
$orderQuery->execute();
$orderResult = $orderQuery->get_result();

if ($orderResult->num_rows === 0) {
    die("Order not found");
}

$order = $orderResult->fetch_assoc();
$itemsQuery = $conn->prepare("
    SELECT oi.*, p.fullName, p.Price, p.imgURL
    FROM OrderItem oi
    JOIN Products p ON oi.productID = p.productID
    WHERE oi.orderID = ?
");
$itemsQuery->bind_param("i", $orderID);
$itemsQuery->execute();
$items = $itemsQuery->get_result()->fetch_all(MYSQLI_ASSOC);

$subtotal = 0;
foreach ($items as $item) {
	$imageID = 'productImage' . $item['productID'];
    $mail->addEmbeddedImage($item['imgURL'], $imageID);
    $subtotal += $item['itemPrice'] * $item['Quantity'];
}

$shippingCost = $order['totalPrice'] - $subtotal;
?>