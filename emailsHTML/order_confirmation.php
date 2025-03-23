<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - GamePoint</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #0078d7;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .email-body {
            padding: 30px;
        }
        .section-title {
            color: #0078d7;
            border-bottom: 2px solid #0078d7;
            padding-bottom: 8px;
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .order-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .order-number {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .order-date {
            font-size: 14px;
            color: #666;
        }
        .order-details {
            margin-bottom: 30px;
        }
        .detail-group {
            margin-bottom: 20px;
        }
        .detail-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .detail-content {
            color: #555;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .product-table th {
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #0078d7;
            color: #0078d7;
        }
        .product-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background-color: #f9f9f9;
            padding: 5px;
            border-radius: 4px;
        }
        .product-name {
            font-weight: bold;
        }
        .order-summary {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            background-color: #0078d7;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
        }
        .center {
            text-align: center;
        }
        .email-footer {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #0078d7;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .email-body {
                padding: 20px;
            }
            .product-table td:first-child {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="logo">GamePoint</div>
            <div>Thank you for your order!</div>
        </div>
        
        <div class="email-body">
            <p>Hi <?php echo htmlspecialchars($row["fullName"]); ?>,</p>
            
            <p>Thank you for your order from GamePoint. We've received your order and are working on processing it right away. Here are your order details:</p>
            
            <div class="order-info">
                <div class="order-number">Order #<?php echo $orderID; ?></div>
                <div class="order-date">Placed on <?php echo date('F j, Y', strtotime($order['orderDate'])); ?></div>
            </div>
            
            <div class="section-title">Order Details</div>
            
            <div class="order-details">
                <div class="detail-group">
                    <div class="detail-label">Shipping Address:</div>
                    <div class="detail-content"><?php echo nl2br(htmlspecialchars($order['ShippingAddress'])); ?></div>
                </div>
                
                <div class="detail-group">
                    <div class="detail-label">Payment Method:</div>
                    <div class="detail-content"><?php echo htmlspecialchars($order['paymentMethod']); ?></div>
                </div>
            </div>
            
            <div class="section-title">Your Items</div>
            
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <?php $imageID = 'productImage' . $item['productID']; ?>
                    <tr>
                    	<td><img src="cid:<?php echo $imageID; ?>" class="product-img" alt="<?php echo htmlspecialchars($item['fullName']); ?>"></td> 
                        <td class="product-name"><?php echo htmlspecialchars($item['fullName']); ?></td>
                        <td><?php echo $item['Quantity']; ?></td>
                        <td>£<?php echo number_format($item['itemPrice'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="order-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>£<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span><?php echo $shippingCost > 0 ? '£' . number_format($shippingCost, 2) : 'FREE'; ?></span>
                </div>
                <div class="total-row">
                    <span>Total:</span>
                    <span>£<?php echo number_format($order['totalPrice'], 2); ?></span>
                </div>
            </div>
            
            <div class="center">
                <a href="https://cs2team8.cs2410-web01pvm.aston.ac.uk/order_history.php" class="btn">View Order Status</a>
            </div>
            
            <p style="margin-top: 30px;">If you have any questions about your order, please contact our customer service team at <a href="mailto:support@gamepoint.com">support@gamepoint.com</a>.</p>
            
            <p>Thank you for shopping with GamePoint!</p>
            
            <p>Best regards,<br>
            The GamePoint Team</p>
        </div>
        
        <div class="email-footer">
            <p>© 2025 GamePoint. All rights reserved.</p>
            <p>Please do not reply to this email. This mailbox is not monitored.</p>
        </div>
    </div>
</body>
</html>