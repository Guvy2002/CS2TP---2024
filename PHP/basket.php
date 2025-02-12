<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('dbconnection.php');
include 'header.php';

?>

<div class="basket-container">
    <h1>Your Shopping Basket</h1>
    <?php
	session_start();
    $total = 0;
    if (!isset($_SESSION["customerID"])) {
        echo '<div class="empty-basket-message">Please log in to view your basket</div>';
    } else {
        $customerID = $_SESSION["customerID"];
        $basketQuery = "SELECT b.basketID, bi.productID, bi.Quantity, p.fullName, p.Price, p.imgURL 
                       FROM Basket b
                       LEFT JOIN BasketItem bi ON b.basketID = bi.basketID
                       LEFT JOIN Products p ON bi.productID = p.productID
                       WHERE b.customerID = ?
                       ORDER BY b.createdDate DESC";
        $stmt = $conn->prepare($basketQuery);
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['productID'] === null) {
                    echo '<div class="empty-basket-message">Your basket is empty</div>';
                    continue;
                }
                $subtotal = $row['Price'] * $row['Quantity'];
                $total += $subtotal;
                ?>
                <div class="basket-item">
                    <img src="<?php echo htmlspecialchars($row['imgURL']); ?>"
                        alt="<?php echo htmlspecialchars($row['fullName']); ?>">
                    <div class="item-details">
                        <div class="item-title"><?php echo htmlspecialchars($row['fullName']); ?></div>
                        <div class="item-price">£<?php echo number_format($row['Price'], 2); ?></div>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="decreaseQuantity(this)">
                                <i class="bi bi-dash-square-fill"></i>
                            </button>
                            <span class="quantity"><?php echo $row['Quantity']; ?></span>
                            <button class="quantity-btn" onclick="increaseQuantity(this)">
                                <i class="bi bi-plus-square-fill"></i>
                            </button>
                        </div>
                    </div>
                    <button onclick="removeItem(this)" class="remove-button">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <?php
            }
        } else {
            echo '<div class="empty-basket-message">Your basket is empty</div>';
        }
    }
    ?>

    <div class="basket-summary">
        <h2>Order Summary</h2>
        <div class="summary-row">
            <span>Subtotal</span>
            <span id="subtotal">£<?php echo number_format($total, 2); ?></span>
        </div>
        <div class="summary-row">
            <span>Shipping</span>
            <span>Free</span>
        </div>
        <hr>
        <div class="summary-row total">
            <span>Total</span>
            <span id="total">£<?php echo number_format($total, 2); ?></span>
        </div>
        <form action="checkout.php" method="POST">
            <input type="hidden" name="order_total" value="<?php echo $total; ?>">
            <button type="submit" class="checkout-button" <?php echo $total > 0 ? '' : 'disabled'; ?>>
                Proceed to Checkout
            </button>
        </form>
    </div>
</div>

<style>
    .basket-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
    }

    .basket-item {
        display: flex;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #eee;
        transition: opacity 0.3s ease;
    }

    .basket-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-right: 20px;
    }

    .item-details {
        flex-grow: 1;
    }

    .item-title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .quantity-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 20px;
        color: #0066cc;
    }

    .remove-button {
        background: none;
        border: none;
        color: #ff4444;
        cursor: pointer;
        font-size: 20px;
        padding: 10px;
    }

    .basket-summary {
        margin-top: 20px;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 5px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin: 10px 0;
        padding: 5px 0;
    }

    .total {
        font-weight: bold;
        font-size: 1.2em;
    }

    .checkout-button {
        width: 100%;
        padding: 15px;
        background: #0066cc;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        font-size: 16px;
    }

    .checkout-button:disabled {
        background: #cccccc;
        cursor: not-allowed;
    }

    .empty-basket-message {
        text-align: center;
        padding: 40px;
        font-size: 18px;
        color: #666;
    }

    .quantity {
        font-size: 16px;
        min-width: 20px;
        text-align: center;
    }
</style>

<script>
    function decreaseQuantity(button) {
        const quantitySpan = button.parentElement.querySelector('.quantity');
        let quantity = parseInt(quantitySpan.textContent);
        if (quantity > 1) {
            quantity--;
            quantitySpan.textContent = quantity;
            updateTotals();
        }
    }

    function increaseQuantity(button) {
        const quantitySpan = button.parentElement.querySelector('.quantity');
        let quantity = parseInt(quantitySpan.textContent);
        quantity++;
        quantitySpan.textContent = quantity;
        updateTotals();
    }

    function removeItem(button) {
        const item = button.closest('.basket-item');
        item.style.opacity = '0';
        setTimeout(() => {
            item.remove();
            updateTotals();
            checkEmptyBasket();
        }, 300);
    }

    function updateTotals() {
        let subtotal = 0;
        const items = document.querySelectorAll('.basket-item');

        items.forEach(item => {
            const price = parseFloat(item.querySelector('.item-price').textContent.replace('£', ''));
            const quantity = parseInt(item.querySelector('.quantity').textContent);
            subtotal += price * quantity;
        });

        document.getElementById('subtotal').textContent = `£${subtotal.toFixed(2)}`;
        document.getElementById('total').textContent = `£${subtotal.toFixed(2)}`;
        document.querySelector('.checkout-button').disabled = subtotal === 0;
    }

    function checkEmptyBasket() {
        const items = document.querySelectorAll('.basket-item');
        if (items.length === 0) {
            const container = document.querySelector('.basket-container');
            const emptyMessage = document.createElement('div');
            emptyMessage.className = 'empty-basket-message';
            emptyMessage.textContent = 'Your basket is empty';
            container.insertBefore(emptyMessage, document.querySelector('.basket-summary'));
        }
    }
</script>

<?php include 'footer.php'; ?>