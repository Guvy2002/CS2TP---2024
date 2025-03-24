<?php
require_once("dbconnection.php");
ob_start();
include 'header.php';

if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order'])) {
    header("Location: homepage.php");
    exit();
}

$orderID = intval($_GET['order']);
$customerID = $_SESSION['customerID'];
$orderQuery = $conn->prepare("
    SELECT * FROM Orders 
    WHERE orderID = ? AND customerID = ?
");
$orderQuery->bind_param("ii", $orderID, $customerID);
$orderQuery->execute();
$orderResult = $orderQuery->get_result();

if ($orderResult->num_rows === 0) {
    header("Location: homepage.php");
    exit();
}

if (isset($_POST['submit_rating'])) {
    $overall_rating = intval($_POST['overall_rating']);
    $website_rating = intval($_POST['website_rating']);
    $delivery_rating = intval($_POST['delivery_rating']);
    $product_rating = intval($_POST['product_rating']);
    $comments = $conn->real_escape_string($_POST['comments']);
    $date = date('Y-m-d');
    $checkQuery = $conn->prepare("SELECT * FROM OrderRatings WHERE orderID = ?");
    $checkQuery->bind_param("i", $orderID);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    if ($result->num_rows > 0) {
        $updateQuery = $conn->prepare("
            UPDATE OrderRatings 
            SET overall_rating = ?, website_rating = ?, delivery_rating = ?, product_rating = ?, comments = ?, date = ?
            WHERE orderID = ?
        ");
        $updateQuery->bind_param("iiiiisi", $overall_rating, $website_rating, $delivery_rating, $product_rating, $comments, $date, $orderID);
        $updateQuery->execute();
        $message = "Thank you! Your rating has been updated.";
    } else {
        $conn->query("
            CREATE TABLE IF NOT EXISTS OrderRatings (
                ratingID INT AUTO_INCREMENT PRIMARY KEY,
                orderID INT NOT NULL,
                customerID INT NOT NULL,
                overall_rating INT NOT NULL,
                website_rating INT NOT NULL,
                delivery_rating INT NOT NULL,
                product_rating INT NOT NULL,
                comments TEXT,
                date DATE NOT NULL,
                FOREIGN KEY (orderID) REFERENCES Orders(orderID),
                FOREIGN KEY (customerID) REFERENCES Customer(customerID)
            )
        ");
        $insertQuery = $conn->prepare("
            INSERT INTO OrderRatings (orderID, customerID, overall_rating, website_rating, delivery_rating, product_rating, comments, date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $insertQuery->bind_param("iiiiiiss", $orderID, $customerID, $overall_rating, $website_rating, $delivery_rating, $product_rating, $comments, $date);
        $insertQuery->execute();
        $message = "Thank you! Your rating has been submitted.";
    }
    $rating_submitted = true;
}
$existingRating = null;
$checkRatingQuery = $conn->prepare("SELECT * FROM OrderRatings WHERE orderID = ? AND customerID = ?");
if ($checkRatingQuery) {
    $checkRatingQuery->bind_param("ii", $orderID, $customerID);
    $checkRatingQuery->execute();
    $ratingResult = $checkRatingQuery->get_result();
    
    if ($ratingResult->num_rows > 0) {
        $existingRating = $ratingResult->fetch_assoc();
    }
}
?>

<style>
    .rating-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .rating-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .rating-header h1 {
        color: #0078d7;
        margin-bottom: 10px;
    }

    .rating-header p {
        color: #666;
        font-size: 16px;
    }

    .rating-form {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .rating-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .rating-group label {
        font-weight: bold;
        color: #333;
        font-size: 16px;
    }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        cursor: pointer;
        width: 40px;
        height: 40px;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="%23ddd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12.73 16.28 5.82 21 7 14 2 9.46 8.91 8.46 12 2" /></svg>');
        background-repeat: no-repeat;
        background-position: center;
        transition: all 0.2s ease;
    }

    .star-rating input:checked ~ label {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="%23FFD700" stroke="%23FFD700" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12.73 16.28 5.82 21 7 14 2 9.46 8.91 8.46 12 2" /></svg>');
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="%23FFD700" stroke="%23FFD700" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12.73 16.28 5.82 21 7 14 2 9.46 8.91 8.46 12 2" /></svg>');
    }

    .comments-area {
        width: 100%;
        min-height: 100px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        resize: vertical;
        transition: border-color 0.3s ease;
    }

    .comments-area:focus {
        border-color: #0078d7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 120, 215, 0.2);
    }

    .submit-button {
        background-color: #0078d7;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 15px 30px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        align-self: center;
        margin-top: 10px;
    }

    .submit-button:hover {
        background-color: #005bb5;
        transform: translateY(-2px);
    }

    .rating-instructions {
        color: #666;
        font-size: 14px;
        margin-top: 5px;
    }

    .success-message {
        text-align: center;
        background-color: #d4edda;
        color: #155724;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }

    .action-button {
        padding: 12px 25px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .continue-shopping {
        background-color: #0078d7;
        color: white;
        border: none;
    }

    .view-orders {
        background-color: white;
        color: #0078d7;
        border: 1px solid #0078d7;
    }

    .continue-shopping:hover, .view-orders:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .continue-shopping:hover {
        background-color: #005bb5;
    }

    .view-orders:hover {
        background-color: #f0f7ff;
    }

    .rating-summary {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .rating-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 16px;
    }

    .rating-value {
        display: flex;
        align-items: center;
    }

    .edit-rating {
        margin-top: 20px;
        text-align: center;
    }

    .edit-button {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .edit-button:hover {
        background-color: #5a6268;
    }

    @media (max-width: 576px) {
        .rating-container {
            padding: 20px;
            margin: 20px 10px;
        }

        .star-rating label {
            width: 30px;
            height: 30px;
            background-size: 30px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-button {
            width: 100%;
        }
    }
</style>

<div class="rating-container">
    <div class="rating-header">
        <h1>Rate Your Experience</h1>
        <p>Your feedback helps us improve our service. Thank you for taking the time to share your thoughts!</p>
    </div>

    <?php if (isset($rating_submitted) && $rating_submitted): ?>
        <div class="success-message">
            <?php echo $message; ?>
        </div>

        <div class="action-buttons">
            <a href="homepage.php" class="action-button continue-shopping">Continue Shopping</a>
            <a href="order_history.php" class="action-button view-orders">View My Orders</a>
        </div>
    <?php elseif ($existingRating): ?>
        <div class="rating-summary">
            <h2>Your Previous Rating</h2>
            <div class="rating-row">
                <span>Overall Experience:</span>
                <div class="rating-value">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $existingRating['overall_rating']): ?>
                            <span style="color: #FFD700; font-size: 24px;">★</span>
                        <?php else: ?>
                            <span style="color: #ddd; font-size: 24px;">★</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="rating-row">
                <span>Website Experience:</span>
                <div class="rating-value">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $existingRating['website_rating']): ?>
                            <span style="color: #FFD700; font-size: 24px;">★</span>
                        <?php else: ?>
                            <span style="color: #ddd; font-size: 24px;">★</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="rating-row">
                <span>Delivery Experience:</span>
                <div class="rating-value">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $existingRating['delivery_rating']): ?>
                            <span style="color: #FFD700; font-size: 24px;">★</span>
                        <?php else: ?>
                            <span style="color: #ddd; font-size: 24px;">★</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="rating-row">
                <span>Product Quality:</span>
                <div class="rating-value">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $existingRating['product_rating']): ?>
                            <span style="color: #FFD700; font-size: 24px;">★</span>
                        <?php else: ?>
                            <span style="color: #ddd; font-size: 24px;">★</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
            <?php if (!empty($existingRating['comments'])): ?>
            <div class="rating-row">
                <span>Your Comments:</span>
            </div>
            <div style="background-color: white; padding: 15px; border-radius: 6px; margin-top: 10px;">
                <?php echo nl2br(htmlspecialchars($existingRating['comments'])); ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="edit-rating">
            <button id="edit-rating-btn" class="edit-button">Edit My Rating</button>
        </div>

        <div id="rating-form-container" style="display: none;">
            <form class="rating-form" method="POST" action="">
                <div class="rating-group">
                    <label>Overall Experience</label>
                    <div class="star-rating">
                        <input type="radio" id="overall-5" name="overall_rating" value="5" <?php echo ($existingRating['overall_rating'] == 5) ? 'checked' : ''; ?>>
                        <label for="overall-5"></label>
                        <input type="radio" id="overall-4" name="overall_rating" value="4" <?php echo ($existingRating['overall_rating'] == 4) ? 'checked' : ''; ?>>
                        <label for="overall-4"></label>
                        <input type="radio" id="overall-3" name="overall_rating" value="3" <?php echo ($existingRating['overall_rating'] == 3) ? 'checked' : ''; ?>>
                        <label for="overall-3"></label>
                        <input type="radio" id="overall-2" name="overall_rating" value="2" <?php echo ($existingRating['overall_rating'] == 2) ? 'checked' : ''; ?>>
                        <label for="overall-2"></label>
                        <input type="radio" id="overall-1" name="overall_rating" value="1" <?php echo ($existingRating['overall_rating'] == 1) ? 'checked' : ''; ?>>
                        <label for="overall-1"></label>
                    </div>
                    <div class="rating-instructions">How would you rate your overall experience with us?</div>
                </div>

                <div class="rating-group">
                    <label>Website Experience</label>
                    <div class="star-rating">
                        <input type="radio" id="website-5" name="website_rating" value="5" <?php echo ($existingRating['website_rating'] == 5) ? 'checked' : ''; ?>>
                        <label for="website-5"></label>
                        <input type="radio" id="website-4" name="website_rating" value="4" <?php echo ($existingRating['website_rating'] == 4) ? 'checked' : ''; ?>>
                        <label for="website-4"></label>
                        <input type="radio" id="website-3" name="website_rating" value="3" <?php echo ($existingRating['website_rating'] == 3) ? 'checked' : ''; ?>>
                        <label for="website-3"></label>
                        <input type="radio" id="website-2" name="website_rating" value="2" <?php echo ($existingRating['website_rating'] == 2) ? 'checked' : ''; ?>>
                        <label for="website-2"></label>
                        <input type="radio" id="website-1" name="website_rating" value="1" <?php echo ($existingRating['website_rating'] == 1) ? 'checked' : ''; ?>>
                        <label for="website-1"></label>
                    </div>
                    <div class="rating-instructions">How easy was it to navigate our website and place your order?</div>
                </div>

                <div class="rating-group">
                    <label>Delivery Experience</label>
                    <div class="star-rating">
                        <input type="radio" id="delivery-5" name="delivery_rating" value="5" <?php echo ($existingRating['delivery_rating'] == 5) ? 'checked' : ''; ?>>
                        <label for="delivery-5"></label>
                        <input type="radio" id="delivery-4" name="delivery_rating" value="4" <?php echo ($existingRating['delivery_rating'] == 4) ? 'checked' : ''; ?>>
                        <label for="delivery-4"></label>
                        <input type="radio" id="delivery-3" name="delivery_rating" value="3" <?php echo ($existingRating['delivery_rating'] == 3) ? 'checked' : ''; ?>>
                        <label for="delivery-3"></label>
                        <input type="radio" id="delivery-2" name="delivery_rating" value="2" <?php echo ($existingRating['delivery_rating'] == 2) ? 'checked' : ''; ?>>
                        <label for="delivery-2"></label>
                        <input type="radio" id="delivery-1" name="delivery_rating" value="1" <?php echo ($existingRating['delivery_rating'] == 1) ? 'checked' : ''; ?>>
                        <label for="delivery-1"></label>
                    </div>
                    <div class="rating-instructions">How satisfied are you with our delivery service and speed?</div>
                </div>

                <div class="rating-group">
                    <label>Product Quality</label>
                    <div class="star-rating">
                        <input type="radio" id="product-5" name="product_rating" value="5" <?php echo ($existingRating['product_rating'] == 5) ? 'checked' : ''; ?>>
                        <label for="product-5"></label>
                        <input type="radio" id="product-4" name="product_rating" value="4" <?php echo ($existingRating['product_rating'] == 4) ? 'checked' : ''; ?>>
                        <label for="product-4"></label>
                        <input type="radio" id="product-3" name="product_rating" value="3" <?php echo ($existingRating['product_rating'] == 3) ? 'checked' : ''; ?>>
                        <label for="product-3"></label>
                        <input type="radio" id="product-2" name="product_rating" value="2" <?php echo ($existingRating['product_rating'] == 2) ? 'checked' : ''; ?>>
                        <label for="product-2"></label>
                        <input type="radio" id="product-1" name="product_rating" value="1" <?php echo ($existingRating['product_rating'] == 1) ? 'checked' : ''; ?>>
                        <label for="product-1"></label>
                    </div>
                    <div class="rating-instructions">How would you rate the quality of the product(s) you received?</div>
                </div>

                <div class="rating-group">
                    <label>Additional Comments</label>
                    <textarea class="comments-area" name="comments" placeholder="Share any additional feedback or suggestions..."><?php echo htmlspecialchars($existingRating['comments']); ?></textarea>
                    <div class="rating-instructions">Let us know if you have any specific feedback or suggestions for improvement.</div>
                </div>

                <button type="submit" name="submit_rating" class="submit-button">Update My Rating</button>
            </form>
        </div>
    <?php else: ?>
        <form class="rating-form" method="POST" action="">
            <div class="rating-group">
                <label>Overall Experience</label>
                <div class="star-rating">
                    <input type="radio" id="overall-5" name="overall_rating" value="5">
                    <label for="overall-5"></label>
                    <input type="radio" id="overall-4" name="overall_rating" value="4">
                    <label for="overall-4"></label>
                    <input type="radio" id="overall-3" name="overall_rating" value="3">
                    <label for="overall-3"></label>
                    <input type="radio" id="overall-2" name="overall_rating" value="2">
                    <label for="overall-2"></label>
                    <input type="radio" id="overall-1" name="overall_rating" value="1" required>
                    <label for="overall-1"></label>
                </div>
                <div class="rating-instructions">How would you rate your overall experience with us?</div>
            </div>

            <div class="rating-group">
                <label>Website Experience</label>
                <div class="star-rating">
                    <input type="radio" id="website-5" name="website_rating" value="5">
                    <label for="website-5"></label>
                    <input type="radio" id="website-4" name="website_rating" value="4">
                    <label for="website-4"></label>
                    <input type="radio" id="website-3" name="website_rating" value="3">
                    <label for="website-3"></label>
                    <input type="radio" id="website-2" name="website_rating" value="2">
                    <label for="website-2"></label>
                    <input type="radio" id="website-1" name="website_rating" value="1" required>
                    <label for="website-1"></label>
                </div>
                <div class="rating-instructions">How easy was it to navigate our website and place your order?</div>
            </div>

            <div class="rating-group">
                <label>Delivery Experience</label>
                <div class="star-rating">
                    <input type="radio" id="delivery-5" name="delivery_rating" value="5">
                    <label for="delivery-5"></label>
                    <input type="radio" id="delivery-4" name="delivery_rating" value="4">
                    <label for="delivery-4"></label>
                    <input type="radio" id="delivery-3" name="delivery_rating" value="3">
                    <label for="delivery-3"></label>
                    <input type="radio" id="delivery-2" name="delivery_rating" value="2">
                    <label for="delivery-2"></label>
                    <input type="radio" id="delivery-1" name="delivery_rating" value="1" required>
                    <label for="delivery-1"></label>
                </div>
                <div class="rating-instructions">How satisfied are you with our delivery service and speed?</div>
            </div>

            <div class="rating-group">
                <label>Product Quality</label>
                <div class="star-rating">
                    <input type="radio" id="product-5" name="product_rating" value="5">
                    <label for="product-5"></label>
                    <input type="radio" id="product-4" name="product_rating" value="4">
                    <label for="product-4"></label>
                    <input type="radio" id="product-3" name="product_rating" value="3">
                    <label for="product-3"></label>
                    <input type="radio" id="product-2" name="product_rating" value="2">
                    <label for="product-2"></label>
                    <input type="radio" id="product-1" name="product_rating" value="1" required>
                    <label for="product-1"></label>
                </div>
                <div class="rating-instructions">How would you rate the quality of the product(s) you received?</div>
            </div>

            <div class="rating-group">
                <label>Additional Comments</label>
                <textarea class="comments-area" name="comments" placeholder="Share any additional feedback or suggestions..."></textarea>
                <div class="rating-instructions">Let us know if you have any specific feedback or suggestions for improvement.</div>
            </div>

            <button type="submit" name="submit_rating" class="submit-button">Submit Rating</button>
        </form>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButton = document.getElementById('edit-rating-btn');
        const formContainer = document.getElementById('rating-form-container');
        
        if (editButton) {
            editButton.addEventListener('click', function() {
                formContainer.style.display = 'block';
                editButton.style.display = 'none';
            });
        }
    });
</script>

<?php 
include 'footer.php'; 
ob_end_flush();
?>