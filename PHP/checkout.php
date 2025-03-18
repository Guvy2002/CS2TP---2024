<?php
require_once('dbconnection.php');
ob_start();
include 'header.php';

if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['customerID'];
$basketItems = [];
$subtotal = 0;
$totalItems = 0;
$error = null;

$basketQuery = $conn->prepare("SELECT b.basketID FROM Basket b WHERE b.customerID = ? ORDER BY b.createdDate DESC LIMIT 1");
$basketQuery->bind_param("i", $customerID);
$basketQuery->execute();
$basketResult = $basketQuery->get_result();

if ($basketResult->num_rows > 0) {
    $basket = $basketResult->fetch_assoc();
    $basketID = $basket['basketID'];

    $itemsQuery = $conn->prepare("
        SELECT bi.basketItemID, bi.productID, bi.Quantity, p.fullName, p.Price, p.imgURL 
        FROM BasketItem bi
        JOIN Products p ON bi.productID = p.productID
        WHERE bi.basketID = ?
    ");
    $itemsQuery->bind_param("i", $basketID);
    $itemsQuery->execute();
    $itemsResult = $itemsQuery->get_result();

    while ($item = $itemsResult->fetch_assoc()) {
        $basketItems[] = $item;
        $subtotal += $item['Price'] * $item['Quantity'];
        $totalItems += $item['Quantity'];
    }
}

setcookie("subtotal", $subtotal, time() + 3600, "/");
setcookie("quantity", $totalItems, time() + 3600, "/");

if (isset($_POST['submit']) && !empty($basketItems)) {
    $customerID = $_SESSION["customerID"];
    $fullName = $_POST['first-name'] . ' ' . $_POST['last-name'];
    $address = $_POST['address1'];
    $address2 = $_POST['address2'];
    $totalAddress = $address . " " . $address2;
    $city = $_POST['city'];
    $postcode = $_POST['postal-code'];
    $shippingMethod = $_POST['shipping-method'];
    $shippingCost = ($shippingMethod === 'express') ? 4.99 : 0;
    $total = $subtotal + $shippingCost;
    $orderDate = date("Y-m-d");
    $orderStatus = "Pending";

    
    $conn->begin_transaction();

    try {
        $paymentMethod = "Credit Card"; // Default payment method
        $paymentStmt = $conn->prepare("INSERT INTO Payment (paymentDate, Amount, paymentMethod) VALUES (?, ?, ?)");
        $paymentStmt->bind_param("sds", $orderDate, $total, $paymentMethod);
        $paymentStmt->execute();
        $paymentID = $conn->insert_id;

        $orderStmt = $conn->prepare("INSERT INTO Orders (customerID, totalPrice, orderDate, orderStatus, BillingAddress, ShippingAddress, paymentID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $orderStmt->bind_param("idssssi", $customerID, $total, $orderDate, $orderStatus, $totalAddress, $totalAddress, $paymentID);
        $orderStmt->execute();
        $orderID = $conn->insert_id;

        $updatePaymentStmt = $conn->prepare("UPDATE Payment SET orderID = ? WHERE paymentID = ?");
        $updatePaymentStmt->bind_param("ii", $orderID, $paymentID);
        $updatePaymentStmt->execute();

        $orderItemStmt = $conn->prepare("INSERT INTO OrderItem (orderID, productID, Quantity, itemPrice) VALUES (?, ?, ?, ?)");
    	$updateInventoryStmt = $conn->prepare("UPDATE Products SET stockQuantity = stockQuantity - ? WHERE productID = ?");

        foreach ($basketItems as $item) {
            $orderItemStmt->bind_param("iiid", $orderID, $item['productID'], $item['Quantity'], $item['Price']);
            $orderItemStmt->execute();
        	$updateInventoryStmt->bind_param("ii", $item['Quantity'], $item['productID']);
            $updateInventoryStmt->execute();
        }

        $action = "Order Created";
        $historyStmt = $conn->prepare("INSERT INTO OrderHistory (customerID, orderID, Action, ActionDate) VALUES (?, ?, ?, ?)");
        $historyStmt->bind_param("iiss", $customerID, $orderID, $action, $orderDate);
        $historyStmt->execute();

        $clearBasketStmt = $conn->prepare("DELETE FROM BasketItem WHERE basketID = ?");
        $clearBasketStmt->bind_param("i", $basketID);
        $clearBasketStmt->execute();

        $conn->commit();

        header("Location: sendEmail.php?contents=order_confirmation&orderID=" . $orderID . "&redirect=" . urlencode("/order_confirmation.php?order=" . $orderID));
		exit();

    } catch (Exception $e) {
        $conn->rollback();
        $error = "An error occurred while processing your order: " . $e->getMessage();
        error_log("Order processing error: " . $e->getMessage());
    }
}
?>

<style>
    .checkout-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }

    @media (max-width: 768px) {
        .checkout-content {
            grid-template-columns: 1fr;
        }
    }

    .checkout-title {
        font-size: 32px;
        color: #333;
        margin-bottom: 30px;
        text-align: left;
    }

    .steps-wrapper {
        margin-bottom: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        background-color: white;
        padding: 25px;
    }

    .section {
        display: none;
    }

    .section.active {
        display: block;
        animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .step-indicator {
        display: flex;
        align-items: center;
        margin-bottom: 40px;
        margin-top: 10px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .step {
        display: flex;
        align-items: center;
        margin-right: 30px;
        position: relative;
    }

    .step:not(:last-child):after {
        content: "";
        position: absolute;
        height: 2px;
        width: 30px;
        background-color: #ccc;
        right: -30px;
        top: 12px;
    }

    .step.active:not(:last-child):after {
        background-color: #0078d7;
    }

    .step-number {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #ccc;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .step.active .step-number {
        background-color: #0078d7;
        transform: scale(1.1);
    }

    .step-title {
        font-size: 16px;
        color: #666;
        transition: all 0.3s ease;
    }

    .step.active .step-title {
        color: #333;
        font-weight: bold;
    }

    .input-group {
        margin-bottom: 25px;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .input-group input,
    .input-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .input-group input:focus,
    .input-group select:focus {
        border-color: #0078d7;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 120, 215, 0.2);
    }

    .input-group.error input {
        border-color: #dc3545;
    }

    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }

    .address-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .shipping-options {
        margin-bottom: 30px;
    }

    .shipping-options .input-group {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .shipping-options .input-group:hover {
        border-color: #0078d7;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .shipping-options input[type="radio"] {
        margin-right: 10px;
        width: auto;
    }

    .shipping-options label {
        display: inline-flex;
        flex-direction: column;
        gap: 5px;
        width: auto;
        cursor: pointer;
    }

    .shipping-title {
        font-weight: bold;
        color: #333;
    }

    .shipping-desc {
        color: #666;
        font-size: 14px;
    }

    .card-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .button-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .back-btn {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 14px 25px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .continue-btn {
        background-color: #0078d7;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 14px 25px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .continue-btn:hover {
        background-color: #005bb5;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .back-btn:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
    }

    .order-summary {
        background-color: white;
        padding: 25px;
        border-radius: 8px;
        position: sticky;
        top: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .summary-title {
        font-size: 22px;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        
    }

    .basket-items {
        margin-bottom: 20px;
        max-height: 300px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .basket-items::-webkit-scrollbar {
        width: 5px;
    }

    .basket-items::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .basket-items::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .basket-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .basket-item:last-child {
        border-bottom: none;
    }

    .basket-item img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-right: 15px;
        background-color: #f9f9f9;
        border-radius: 4px;
        padding: 5px;
    }

    .item-details {
        flex-grow: 1;
    }

    .item-name {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .item-price {
        font-size: 14px;
        font-weight: 600;
        color: #0078d7;
    }

    .item-quantity {
        font-size: 13px;
        color: #666;
    }

    .subtotal-row,
    .shipping-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        font-size: 15px;
    }

    .total-section {
        margin-top: 20px;
        padding-top: 15px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        font-size: 18px;
        color: #333;
    }

    .review-sections {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .review-section {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 20px;
        position: relative;
        transition: all 0.3s ease;
    }

    .review-section:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .review-section h3 {
        margin-bottom: 15px;
        color: #333;
        font-size: 18px;
    }

    .edit-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: #0078d7;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .edit-btn:hover {
        text-decoration: underline;
        color: #005bb5;
    }

    .empty-basket-message {
        text-align: center;
        padding: 40px 20px;
        color: #666;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .empty-basket-message p {
        margin-bottom: 20px;
        font-size: 16px;
    }

    .error-alert {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border-left: 4px solid #dc3545;
        font-size: 15px;
    }

    .section h2 {
        color: #333;
        font-size: 22px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    @media (max-width: 576px) {

        .address-grid,
        .card-details-grid {
            grid-template-columns: 1fr;
        }

        .step-indicator {
            flex-wrap: wrap;
        }

        .step {
            margin-bottom: 10px;
        }

        .button-group {
            flex-direction: column;
        }

        .back-btn,
        .continue-btn {
            width: 100%;
        }
    }
</style>

<div class="checkout-content">
    <div class="main-checkout">
        <h1 class="checkout-title">Checkout</h1>

        <?php if (empty($basketItems)): ?>
            <div class="empty-basket-message">
                <p>Your basket is empty. Please add items before proceeding to checkout.</p>
                <a href="homepage.php" class="continue-btn" style="display: inline-block; margin-top: 20px;">Continue
                    Shopping</a>
            </div>
        <?php else: ?>

            <?php if (isset($error)): ?>
                <div class="error-alert"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="steps-wrapper">
                <div class="step-indicator">
                    <div class="step active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-title">Shipping address</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-title">Shipping method</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-title">Payment</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-number">4</div>
                        <div class="step-title">Review & place order</div>
                    </div>
                </div>

                <form id="checkout-form" method="POST" onsubmit="return validateForm()">
                    <div class="section active" data-section="1">
                        <h2>Shipping Address</h2>
                        <div class="input-group">
                            <label for="first-name">FIRST NAME *</label>
                            <input type="text" id="first-name" name="first-name" required>
                            <div class="error-message"></div>
                        </div>
                        <div class="input-group">
                            <label for="last-name">LAST NAME *</label>
                            <input type="text" id="last-name" name="last-name" required>
                            <div class="error-message"></div>
                        </div>
                        <div class="input-group">
                            <label for="address1">ADDRESS 1 - STREET OR P.O. BOX *</label>
                            <input type="text" id="address1" name="address1" required>
                            <div class="error-message"></div>
                        </div>
                        <div class="input-group">
                            <label for="address2">ADDRESS 2 - APT, SUITE, FLOOR</label>
                            <input type="text" id="address2" name="address2"
                                placeholder="Leave blank if P.O. Box in Address 1">
                        </div>
                        <div class="address-grid">
                            <div class="input-group">
                                <label for="postal-code">ZIP CODE *</label>
                                <input type="text" id="postal-code" name="postal-code" required>
                                <div class="error-message"></div>
                            </div>
                            <div class="input-group">
                                <label for="city">CITY *</label>
                                <input type="text" id="city" name="city" required>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        <button type="button" class="continue-btn" onclick="validateAndContinue(1)">Continue to shipping
                            method</button>
                    </div>

                    <div class="section" data-section="2">
                        <h2>Select Shipping Method</h2>
                        <div class="shipping-options">
                            <div class="input-group">
                                <input type="radio" id="standard-shipping" name="shipping-method" value="standard" checked>
                                <label for="standard-shipping">
                                    <span class="shipping-title">Standard Delivery (FREE)</span>
                                    <span class="shipping-desc">Delivery within 3-5 working days</span>
                                </label>
                            </div>
                            <div class="input-group">
                                <input type="radio" id="express-shipping" name="shipping-method" value="express">
                                <label for="express-shipping">
                                    <span class="shipping-title">Express Delivery (£4.99)</span>
                                    <span class="shipping-desc">Next working day delivery for orders placed before
                                        2pm</span>
                                </label>
                            </div>
                        </div>
                        <div class="button-group">
                            <button type="button" class="back-btn" onclick="previousStep(2)">Back</button>
                            <button type="button" class="continue-btn" onclick="nextStep(2)">Continue to payment</button>
                        </div>
                    </div>

                    <div class="section" data-section="3">
                        <h2>Payment Information</h2>
                        <div class="payment-form">
                            <div class="input-group">
                                <label for="card-number">CARD NUMBER *</label>
                                <input type="text" id="card-number" name="card-number" maxlength="19"
                                    placeholder="1234 5678 9012 3456" required>
                                <div class="error-message"></div>
                            </div>
                            <div class="card-details-grid">
                                <div class="input-group">
                                    <label for="expiry-date">EXPIRY DATE *</label>
                                    <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" maxlength="5"
                                        required>
                                    <div class="error-message"></div>
                                </div>
                                <div class="input-group">
                                    <label for="cvv">CVV *</label>
                                    <input type="text" id="cvv" name="cvv" maxlength="4" placeholder="123" required>
                                    <div class="error-message"></div>
                                </div>
                            </div>
                            <div class="input-group">
                                <label for="card-name">NAME ON CARD *</label>
                                <input type="text" id="card-name" name="card-name" required>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        <div class="button-group">
                            <button type="button" class="back-btn" onclick="previousStep(3)">Back</button>
                            <button type="button" class="continue-btn" onclick="validateAndContinue(3)">Review
                                order</button>
                        </div>
                    </div>

                    <div class="section" data-section="4">
                        <h2>Review Your Order</h2>
                        <div class="review-sections">
                            <div class="review-section">
                                <h3>Shipping Address</h3>
                                <div class="review-content" id="shipping-review"></div>
                                <button type="button" class="edit-btn" onclick="editSection(1)">Edit</button>
                            </div>
                            <div class="review-section">
                                <h3>Shipping Method</h3>
                                <div class="review-content" id="shipping-method-review"></div>
                                <button type="button" class="edit-btn" onclick="editSection(2)">Edit</button>
                            </div>
                            <div class="review-section">
                                <h3>Payment Method</h3>
                                <div class="review-content" id="payment-review"></div>
                                <button type="button" class="edit-btn" onclick="editSection(3)">Edit</button>
                            </div>
                            <div class="review-section">
                                <h3>Order Items</h3>
                                <div class="review-content">
                                    <?php foreach ($basketItems as $item): ?>
                                        <div class="basket-item">
                                            <div class="item-details">
                                                <div class="item-name"><?php echo htmlspecialchars($item['fullName']); ?></div>
                                                <div class="item-price">£<?php echo number_format($item['Price'], 2); ?></div>
                                                <div class="item-quantity">Quantity: <?php echo $item['Quantity']; ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="subtotal-row" style="margin-top: 15px;">
                                        <span>Subtotal:</span>
                                        <span>£<?php echo number_format($subtotal, 2); ?></span>
                                    </div>
                                    <div class="shipping-row">
                                        <span>Shipping:</span>
                                        <span id="review-shipping-cost">FREE</span>
                                    </div>
                                    <div class="total-row">
                                        <span>Total:</span>
                                        <span id="review-total-amount">£<?php echo number_format($subtotal, 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-group">
                            <button type="button" class="back-btn" onclick="previousStep(4)">Back</button>
                            <button type="submit" name="submit" class="continue-btn">Place order</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($basketItems)): ?>
        <div class="order-summary">
            <h2 class="summary-title">Order Summary</h2>

            <div class="basket-items">
                <?php foreach ($basketItems as $item): ?>
                    <div class="basket-item">
                        <img src="<?php echo htmlspecialchars($item['imgURL']); ?>"
                            alt="<?php echo htmlspecialchars($item['fullName']); ?>">
                        <div class="item-details">
                            <div class="item-name"><?php echo htmlspecialchars($item['fullName']); ?></div>
                            <div class="item-price">£<?php echo number_format($item['Price'], 2); ?></div>
                            <div class="item-quantity">Quantity: <?php echo $item['Quantity']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="subtotal-row">
                <span>Subtotal</span>
                <span>£<?php echo number_format($subtotal, 2); ?></span>
            </div>
            <div class="shipping-row">
                <span>Shipping</span>
                <span id="shipping-cost">FREE</span>
            </div>
            <div class="total-section">
                <div class="total-row">
                    <span>Total</span>
                    <span id="total-amount">£<?php echo number_format($subtotal, 2); ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function validateAndContinue(currentStep) {
        let isValid = true;

        if (currentStep === 1) {
            const required = ['first-name', 'last-name', 'address1', 'postal-code', 'city'];
            required.forEach(field => {
                const input = document.getElementById(field);
                const errorDiv = input.nextElementSibling;
                if (!input.value.trim()) {
                    isValid = false;
                    input.parentElement.classList.add('error');
                    errorDiv.textContent = 'This field is required';
                } else {
                    input.parentElement.classList.remove('error');
                    errorDiv.textContent = '';
                }
            });

            const postalCode = document.getElementById('postal-code').value.trim();
            const postalRegex = /^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i;
            if (postalCode && !postalRegex.test(postalCode)) {
                isValid = false;
                document.getElementById('postal-code').parentElement.classList.add('error');
                document.getElementById('postal-code').nextElementSibling.textContent = 'Please enter a valid postal code';
            }
        }

        if (currentStep === 3) {
            const cardNumber = document.getElementById('card-number').value.replace(/\s/g, '');
            if (!/^\d{16}$/.test(cardNumber)) {
                isValid = false;
                document.getElementById('card-number').parentElement.classList.add('error');
                document.getElementById('card-number').nextElementSibling.textContent = 'Please enter a valid 16-digit card number';
            } else {
                document.getElementById('card-number').parentElement.classList.remove('error');
                document.getElementById('card-number').nextElementSibling.textContent = '';
            }

            const expiryDate = document.getElementById('expiry-date').value;
            const [month, year] = expiryDate.split('/');
            const now = new Date();
            const currentYear = now.getFullYear() % 100;
            const currentMonth = now.getMonth() + 1;

            if (!/^\d{2}\/\d{2}$/.test(expiryDate) ||
                parseInt(month) < 1 ||
                parseInt(month) > 12 ||
                parseInt(year) < currentYear ||
                (parseInt(year) === currentYear && parseInt(month) < currentMonth)) {
                isValid = false;
                document.getElementById('expiry-date').parentElement.classList.add('error');
                document.getElementById('expiry-date').nextElementSibling.textContent = 'Please enter a valid expiry date';
            } else {
                document.getElementById('expiry-date').parentElement.classList.remove('error');
                document.getElementById('expiry-date').nextElementSibling.textContent = '';
            }

            const cvv = document.getElementById('cvv').value;
            if (!/^\d{3,4}$/.test(cvv)) {
                isValid = false;
                document.getElementById('cvv').parentElement.classList.add('error');
                document.getElementById('cvv').nextElementSibling.textContent = 'Please enter a valid CVV';
            } else {
                document.getElementById('cvv').parentElement.classList.remove('error');
                document.getElementById('cvv').nextElementSibling.textContent = '';
            }

            const cardName = document.getElementById('card-name').value.trim();
            if (!cardName || cardName.length < 2) {
                isValid = false;
                document.getElementById('card-name').parentElement.classList.add('error');
                document.getElementById('card-name').nextElementSibling.textContent = 'Please enter the name as it appears on your card';
            } else {
                document.getElementById('card-name').parentElement.classList.remove('error');
                document.getElementById('card-name').nextElementSibling.textContent = '';
            }
        }

        if (isValid) {
            nextStep(currentStep);
            if (currentStep === 3) {
                updateReviewSection();
            }
        }
    }

    function validateForm() {
        const required = ['first-name', 'last-name', 'address1', 'postal-code', 'city', 'card-number', 'expiry-date', 'cvv', 'card-name'];
        let isValid = true;

        required.forEach(field => {
            if (!document.getElementById(field).value.trim()) {
                isValid = false;
            }
        });

        if (!isValid) {
            alert('Please complete all required fields before placing your order.');
            return false;
        }

        return true;
    }

    function nextStep(currentStep) {
        document.querySelector(`.section[data-section="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.section[data-section="${currentStep + 1}"]`).classList.add('active');
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${currentStep + 1}"]`).classList.add('active');
        document.querySelector('.checkout-content').scrollIntoView({ behavior: 'smooth' });
    }

    function previousStep(currentStep) {
        document.querySelector(`.section[data-section="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.section[data-section="${currentStep - 1}"]`).classList.add('active');
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${currentStep - 1}"]`).classList.add('active');
        document.querySelector('.checkout-content').scrollIntoView({ behavior: 'smooth' });
    }

    function editSection(sectionNumber) {
        document.querySelector('.section.active').classList.remove('active');
        document.querySelector(`.section[data-section="${sectionNumber}"]`).classList.add('active');
        document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
        document.querySelector(`.step[data-step="${sectionNumber}"]`).classList.add('active');
        document.querySelector('.checkout-content').scrollIntoView({ behavior: 'smooth' });
    }

    function updateReviewSection() {
        const firstName = document.getElementById('first-name').value;
        const lastName = document.getElementById('last-name').value;
        const address1 = document.getElementById('address1').value;
        const address2 = document.getElementById('address2').value;
        const city = document.getElementById('city').value;
        const postalCode = document.getElementById('postal-code').value;

        document.getElementById('shipping-review').innerHTML = `
        ${firstName} ${lastName}<br>
        ${address1}<br>
        ${address2 ? address2 + '<br>' : ''}
        ${city}, ${postalCode}
    `;

        const shippingMethod = document.querySelector('input[name="shipping-method"]:checked');
        document.getElementById('shipping-method-review').innerHTML =
            shippingMethod.id === 'standard-shipping'
                ? 'Standard Delivery (3-5 working days)'
                : 'Express Delivery (Next working day)';

        const cardNumber = document.getElementById('card-number').value;
        const lastFourDigits = cardNumber.replace(/\s/g, '').slice(-4);
        document.getElementById('payment-review').innerHTML = `
        Card ending in ${lastFourDigits}<br>
        Expires: ${document.getElementById('expiry-date').value}
    `;

        const shippingCostElement = document.getElementById('review-shipping-cost');
        const totalElement = document.getElementById('review-total-amount');
        const subtotal = <?php echo $subtotal; ?>;

        if (shippingMethod.value === 'express') {
            shippingCostElement.textContent = '£4.99';
            totalElement.textContent = '£' + (subtotal + 4.99).toFixed(2);
        } else {
            shippingCostElement.textContent = 'FREE';
            totalElement.textContent = '£' + subtotal.toFixed(2);
        }
    }

    document.querySelectorAll('input[name="shipping-method"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const shippingCostElement = document.getElementById('shipping-cost');
            const totalElement = document.getElementById('total-amount');
            const subtotal = <?php echo $subtotal; ?>;

            if (this.value === 'express') {
                shippingCostElement.textContent = '£4.99';
                totalElement.textContent = '£' + (subtotal + 4.99).toFixed(2);
            } else {
                shippingCostElement.textContent = 'FREE';
                totalElement.textContent = '£' + subtotal.toFixed(2);
            }
        });
    });

    document.getElementById('card-number').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || '';
        e.target.value = formattedValue;
    });

    document.getElementById('expiry-date').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0, 2) + '/' + value.slice(2);
        }
        e.target.value = value;
    });

    document.getElementById('cvv').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
</script>

<?php include 'footer.php'; ?>
