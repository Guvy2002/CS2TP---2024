<?php

require_once('dbconnection.php');
session_start();

if (isset($_POST['submit'])) {
    $customerID = $_SESSION["customerID"];
    $fullName = $_POST['full-name'];
    $contactNumber = $_POST['number'];
    $address = $_POST['address'];
    $address2 = $_POST['address2'];
    $totalAddress = $address . " " . $address2;
    $city = $_POST['city'];
    $postcode = $_POST['postal-code'];
    $country = $_POST['country'];
    $cardName = $_POST['card-name'];
    $cardAddress = $_POST['card-address'];
    $cardAddress2 = $_POST['card-address2'];
    $totalCardAddress = $cardAddress . " " . $cardAddress2;
    $cardNumber = $_POST['card-number'];
    $expiryMonth = $_POST['expiry'];
    $cvv = $_POST['cvv'];
    $quantity = $_COOKIE["quantity"];
    $subtotal = $_COOKIE["subtotal"];
    $date = date("y-m-d");
    $type = 'Card';

    try {
        if ($postcode > 10) {
            throw new exception("Postcode is to long");
        }
        if ($cardNumber > 19) {
            throw new exception("Card number is to long");
        }
        if ($cvv > 3) {
            throw new exception("CVV/CVC is to long");
        }
        $stmt = $conn->prepare("INSERT INTO Orders (customerID, totalPrice, OrderDate, BillingAddress, ShippingAddress) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $customerID, $subtotal, $date, $totalCardAddress, $totalAddress);
        $ordersID = "SELECT orderID, customerID FROM Orders";
        $ordersIDsResult = mysqli_query->query($conn, $ordersID);
        if (mysqli_num_rows($ordersIDsResult) > 0) {
            while ($row = mysqli_fetch_assoc($ordersIDsResult)) {
                if ($row['customerID'] == $customerID) {
                    $orderID = $row['orderID'];
                }
            }
        }
        $stmt = $conn->prepare("INSERT INTO Payment (orderID, paymentDate, Amount, paymentMethod) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $orderID, $date, $subtotal, $type);
        $paymentIDs = "SELECT orderID, paymentID FROM Payment";
        $paymentIDsResult = mysqli_query->query($conn, $paymentIDs);
        if (mysqli_num_rows($paymentIDsResult) > 0) {
            while ($row = mysqli_fetch_assoc($paymentIDsResult)) {
                if ($row['orderID'] == $orderID) {
                    $paymentID = $row['paymentID'];
                    $stmt = $conn->prepare("INSERT INTO Orders (paymentID) VALUES (?)");
                    $stmt->bind_param("s", $paymentID);
                }
            }
        }
        mysqli_close($conn);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}
include 'header.php';
?>

<body>
    <style>
        .checkout-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .section h3 {
            margin-bottom: 15px;
        }

        .input-group {
            margin-bottom: 10px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .order-summary {
            list-style-type: none;
            padding: 0;
        }

        .order-summary li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: darkred;
        }
    </style>

    <!-- Checkout Container -->
    <div class="checkout-container">
        <h1>Checkout</h1>

        <!-- Cart Total -->
        <div class="section">
            <h3>Order Total</h3>
            <ul class="order-summary">
                <li>
                    <span>Subtotal:</span>
                    <span>£<?php echo isset($_POST['order_total']) ? number_format($_POST['order_total'], 2) : '0.00'; ?></span>
                </li>
                <li>
                    <span>Shipping:</span>
                    <span>Free</span>
                </li>
                <li class="total">
                    <span>Total:</span>
                    <span>£<?php echo isset($_POST['order_total']) ? number_format($_POST['order_total'], 2) : '0.00'; ?></span>
                </li>
            </ul>
        </div>

        <!-- Shipping Information -->
        <div class="section">
            <h3>Billing Information</h3>
            <form>
                <div class="input-group">
                    <label for="full-name">Full Name*</label>
                    <input type="text" id="full-name" name="full-name" required>
                </div>
                <div class="input-group">
                    <label for="number">Contact Number*</label>
                    <input type="tel" id="number" name="number" required>
                </div>
                <div class="input-group">
                    <label for="address">Address Line 1*</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="input-group">
                    <label for="address2">Address Line 2*</label>
                    <input type="text" id="address2" name="address2" required>
                </div>
                <div class="input-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="input-group">
                    <label for="postal-code">Postal Code*</label>
                    <input type="text" id="postal-code" name="postal-code" required>
                </div>
                <div class="input-group">
                    <label for="country">Country*</label>
                    <select id="country" name="country" required>
                        <option value="uk">United Kingdom</option>
                        <option value="us">United States</option>
                        <option value="ca">Canada</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="section">
            <h3>Shipping Information</h3>
            <form>
                <div class="input-group">
                    <label for="full-name">Full Name*</label>
                    <input type="text" id="full-name" name="full-name" required>
                </div>
                <div class="input-group">
                    <label for="number">Contact Number*</label>
                    <input type="tel" id="number" name="number" required>
                </div>
                <div class="input-group">
                    <label for="address">Address Line 1*</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="input-group">
                    <label for="address2">Address Line 2</label>
                    <input type="text" id="address2" name="address2" required>
                </div>
                <div class="input-group">
                    <label for="city">City*</label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="input-group">
                    <label for="postal-code">Postal Code*</label>
                    <input type="text" id="postal-code" name="postal-code" required>
                </div>
                <div class="input-group">
                    <label for="country">Country*</label>
                    <select id="country" name="country" required>
                        <option value="uk">United Kingdom</option>
                        <option value="us">United States</option>
                        <option value="ca">Canada</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <h3>Payment Information</h3>
            <form>
                <div class="input-group">
                    <label for="card-name">Name on Card*</label>
                    <input type="text" id="card-name" name="card-name" required>
                </div>
                <div class="input-group">
                    <label for="card-number">Card Number*</label>
                    <input type="text" id="card-number" name="card-number" required>
                </div>
                <div class="input-group">
                    <label for="card-address">Address Line 1*</label>
                    <input type="text" id="card-address" name="card-address" required>
                </div>
                <div class="input-group">
                    <label for="card-address2">Address Line 2</label>
                    <input type="text" id="card-address2" name="card-address2" required>
                </div>
                <div class="input-group">
                    <label for="expiry">Expiry Date*</label>
                    <input type="month" id="expiry" name="expiry" required>
                </div>
                <div class="input-group">
                    <label for="cvv">CVV/CVC*</label>
                    <input type="number" id="cvv" name="cvv" required>
                </div>
            </form>
        </div>

        <!-- Confirm Order Button -->
        <button class="confirm-order-btn">Confirm Order</button>
    </div>
    <?php include 'footer.php'; ?>
    </section>
</body>

</html>