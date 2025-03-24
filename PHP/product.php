<?php
require_once 'dbconnection.php';
$error_message = '';
$success_message = '';

$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$productId) {
    header('Location: homepage.php');
    exit();
}

$sql = "SELECT p.*, c.categoryName 
        FROM Products p 
        JOIN Category c ON p.categoryID = c.categoryID 
        WHERE productID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header('Location: homepage.php');
    exit();
}

$sql = "SELECT * FROM Products 
        WHERE categoryID = ? AND productID != ? 
        LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $product['categoryID'], $productId);
$stmt->execute();
$relatedProducts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT rating, review FROM ItemReview WHERE productID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$reviews = $stmt->get_result();

$avgRatingQuery = "SELECT AVG(rating) as avg_rating, COUNT(*) as count FROM ItemReview WHERE productID = ?";
$stmt = $conn->prepare($avgRatingQuery);
$stmt->bind_param("i", $productId);
$stmt->execute();
$ratingData = $stmt->get_result()->fetch_assoc();
$avgRating = $ratingData['avg_rating'] ? round($ratingData['avg_rating'], 1) : 0;
$reviewCount = $ratingData['count'];

if (isset($_POST["submit_review"])) {
    $inputReview = trim($_POST["review"]);
    $inputRating = isset($_COOKIE["rating"]) ? intval($_COOKIE["rating"]) : 0;
    if ($inputRating == 0) {
        $error_message = "Please select a rating.";
    } else {
        try {
            setcookie("rating", "", time() - 3600, "/");
            $stmt = $conn->prepare("INSERT INTO ItemReview (productID, rating, review) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $productId, $inputRating, $inputReview);
            if ($stmt->execute()) {
                $success_message = "Thank you! Your rating" . ($inputReview ? " and review" : "") . " has been submitted.";
                header("Refresh: 2; URL=" . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                $error_message = "Error submitting review. Please try again.";
            }
        } catch (Exception $ex) {
            $error_message = "Error: " . $ex->getMessage();
        }
    }
}

ob_start();
include 'header.php';
?>

<div class="product-container">
    <div class="breadcrumb">
        <a href="homepage.php">Home</a>
        <span class="separator">›</span>
        <span class="category"><?php echo htmlspecialchars($product['categoryName']); ?></span>
        <span class="separator">›</span>
        <span class="current"><?php echo htmlspecialchars($product['fullName']); ?></span>
    </div>

    <div class="product-main">
        <div class="product-gallery">
            <div class="main-image-container">
                <img src="<?php echo htmlspecialchars($product['imgURL']); ?>"
                    alt="<?php echo htmlspecialchars($product['fullName']); ?>" id="main-product-image">
                <div class="image-zoom-overlay"></div>
            </div>
        </div>

        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['fullName']); ?></h1>
            <p class="model-no">Model: <?php echo htmlspecialchars($product['ModelNo']); ?></p>

            <div class="rating-summary">
                <div class="stars-display" title="<?php echo $avgRating; ?> out of 5 stars">
                    <?php
                    $fullStars = floor($avgRating);
                    $halfStar = round($avgRating - $fullStars, 1) >= 0.5;

                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $fullStars) {
                            echo '<i class="bi bi-star-fill"></i>';
                        } elseif ($i == $fullStars + 1 && $halfStar) {
                            echo '<i class="bi bi-star-half"></i>';
                        } else {
                            echo '<i class="bi bi-star"></i>';
                        }
                    }
                    ?>
                </div>
                <span class="rating-count"><?php echo $reviewCount; ?> reviews</span>
            </div>

            <div class="price-section">
                <div class="price-container">
                    <span class="current-price">£<?php echo number_format($product['Price'], 2); ?></span>
                    <span class="price-note">Inc. VAT</span>
                </div>

                <div class="stock-info <?php echo $product['stockQuantity'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                    <?php if ($product['stockQuantity'] > 0): ?>
                        <i class="bi bi-check-circle-fill"></i> In Stock
                        <span class="stock-count">(<?php if ($product['stockQuantity'] > 10) {
                            echo '10+';
                        } else {
                            echo $product['stockQuantity'];
                        } ?> available)</span>
                        <p class="delivery-info"><i class="bi bi-truck"></i> FREE Next Day Delivery</p>
                    <?php else: ?>
                        <i class="bi bi-x-circle-fill"></i> Out of Stock
                        <p class="delivery-info">Usually ships within 2-3 weeks</p>
                    <?php endif; ?>
                </div>

            </div>

            <div class="purchase-options">
                <?php if ($product['stockQuantity'] > 0): ?>
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn minus-btn" aria-label="Decrease quantity">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" id="quantity" name="quantity" min="1"
                                max="<?php echo min(10, $product['stockQuantity']); ?>" value="1">
                            <button type="button" class="quantity-btn plus-btn" aria-label="Increase quantity">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button class="add-to-basket-btn"
                            onclick="addToBasket(<?php echo $product['productID']; ?>, document.getElementById('quantity').value)">
                            <i class="bi bi-cart-plus"></i> Add to Basket
                        </button>
                        <button class="add-to-wishlist-btn" onclick="addToWishlist(<?php echo $product['productID']; ?>)">
                            <i class="bi bi-heart"></i> Add to Wishlist
                        </button>
                    </div>
                <?php else: ?>
                    <button class="notify-btn">
                        <i class="bi bi-bell"></i> Notify When Available
                    </button>
                <?php endif; ?>
            </div>

            <?php if (!empty($product['Description'])): ?>
                <div class="product-description">
                    <h2>Product Description</h2>
                    <p><?php echo nl2br(htmlspecialchars($product['Description'])); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($product['Supplier']): ?>
                <div class="supplier-info">
                    <p>Supplied by: <strong><?php echo htmlspecialchars($product['Supplier']); ?></strong></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="reviews-section">
        <h2>Customer Reviews</h2>
        <div class="reviews-summary">
            <div class="average-rating">
                <div class="big-rating"><?php echo $avgRating; ?></div>
                <div class="stars-display large">
                    <?php
                    $fullStars = floor($avgRating);
                    $halfStar = round($avgRating - $fullStars, 1) >= 0.5;

                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $fullStars) {
                            echo '<i class="bi bi-star-fill"></i>';
                        } elseif ($i == $fullStars + 1 && $halfStar) {
                            echo '<i class="bi bi-star-half"></i>';
                        } else {
                            echo '<i class="bi bi-star"></i>';
                        }
                    }
                    ?>
                </div>
                <div class="review-count"><?php echo $reviewCount; ?> reviews</div>
            </div>
            <div class="write-review-cta">
                <button id="write-review-btn" class="write-review-btn">
                    <i class="bi bi-pencil"></i> Write a Review
                </button>
            </div>
        </div>

        <div id="review-form-container" class="review-form-container">
            <form id="review-form" method="POST" action="">
                <h3>Write Your Review</h3>

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

                <div class="rating-input">
                    <label>Your Rating: <span class="required">*</span></label>
                    <div class="star-rating">
                        <span class="star" data-value="1" title="Poor"><i class="bi bi-star"></i></span>
                        <span class="star" data-value="2" title="Fair"><i class="bi bi-star"></i></span>
                        <span class="star" data-value="3" title="Average"><i class="bi bi-star"></i></span>
                        <span class="star" data-value="4" title="Good"><i class="bi bi-star"></i></span>
                        <span class="star" data-value="5" title="Excellent"><i class="bi bi-star"></i></span>
                    </div>
                    <div id="rating-value">Rating: <span>0</span>/5</div>
                </div>

                <div class="form-group">
                    <label for="review-text">Your Review: <span class="optional">(optional)</span></label>
                    <textarea id="review-text" name="review" rows="5"
                        placeholder="Share your experience with this product..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" id="cancel-review" class="cancel-btn">Cancel</button>
                    <button type="submit" name="submit_review" class="submit-btn">Submit Review</button>
                </div>
            </form>
        </div>

        <div class="reviews-container">
            <?php if ($reviews->num_rows > 0): ?>
                <div class="review-list">
                    <?php while ($review = $reviews->fetch_assoc()): ?>
                        <div class="review-item">
                            <div class="review-header">
                                <div class="star-rating-display">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $review["rating"]
                                            ? '<i class="bi bi-star-fill"></i>'
                                            : '<i class="bi bi-star"></i>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php if (!empty($review["review"])): ?>
                                <div class="review-content"><?php echo htmlspecialchars($review["review"]); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-reviews">
                    <p>This product has no reviews yet. Be the first to leave a review!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($relatedProducts)): ?>
        <div class="related-products">
            <h2>You May Also Like</h2>
            <div class="products-grid">
                <?php foreach ($relatedProducts as $related): ?>
                    <div class="product-card">
                        <a href="product.php?id=<?php echo $related['productID']; ?>">
                            <div class="product-card-image">
                                <img src="<?php echo htmlspecialchars($related['imgURL']); ?>"
                                    alt="<?php echo htmlspecialchars($related['fullName']); ?>">
                            </div>
                            <div class="product-card-content">
                                <h3><?php echo htmlspecialchars($related['fullName']); ?></h3>
                                <div class="price">£<?php echo number_format($related['Price'], 2); ?></div>
                                <div class="product-card-cta">View Details</div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div id="notification-toast" class="notification-toast">
    <div class="notification-content">
        <i class="notification-icon bi"></i>
        <span id="notification-message"></span>
    </div>
    <button class="close-notification" aria-label="Close notification">×</button>
</div>

<style>
    .product-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 0 20px;
        font-family: Arial, sans-serif;
        color: var(--text-color);
    }

    .breadcrumb {
        margin-bottom: 30px;
        font-size: 14px;
        color: var(--text-color);
        opacity: 0.7;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .breadcrumb a {
        color: var(--heading-color);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb a:hover {
        color: var(--heading-color);
        opacity: 0.8;
        text-decoration: underline;
    }

    .breadcrumb .separator {
        margin: 0 8px;
        color: var(--text-color);
        opacity: 0.5;
    }

    .breadcrumb .category {
        color: var(--text-color);
        opacity: 0.8;
    }

    .breadcrumb .current {
        color: var(--text-color);
        font-weight: 500;
    }

    .product-main {
        display: grid;
        grid-template-columns: minmax(300px, 1fr) minmax(300px, 1fr);
        gap: 40px;
        margin-bottom: 50px;
        align-items: start;
    }

    .product-gallery {
        position: sticky;
        top: 100px;
    }

    .main-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        background-color: var(--card-bg);
        box-shadow: 0 2px 10px var(--card-shadow);
        padding: 20px;
        cursor: zoom-in;
    }

    .main-image-container img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
        background-color: white;
        border-radius: 4px;
    }

    .main-image-container:hover img {
        transform: scale(1.1);
    }

    .image-zoom-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.1);
        pointer-events: none;
    }

    .product-info {
        padding: 20px;
        background-color: var(--card-bg);
        border-radius: 8px;
        box-shadow: 0 2px 10px var(--card-shadow);
    }

    .product-info h1 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 28px;
        color: var(--heading-color);
        line-height: 1.3;
    }

    .model-no {
        color: var(--text-color);
        opacity: 0.7;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .rating-summary {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .stars-display {
        color: #ffb31a;
        font-size: 18px;
        letter-spacing: 2px;
    }

    .stars-display.large {
        font-size: 24px;
    }

    .rating-count {
        color: var(--text-color);
        opacity: 0.7;
        font-size: 14px;
    }

    .price-section {
        margin: 25px 0;
        padding: 15px;
        background-color: var(--background-color);
        border-radius: 6px;
        box-shadow: inset 0 0 5px var(--card-shadow);
    }

    .price-container {
        display: flex;
        align-items: baseline;
        margin-bottom: 10px;
    }

    .current-price {
        font-size: 32px;
        font-weight: bold;
        color: var(--heading-color);
        margin-right: 10px;
    }

    .price-note {
        color: var(--text-color);
        opacity: 0.7;
        font-size: 14px;
    }

    .stock-info {
        font-size: 16px;
        font-weight: 500;
        padding: 10px 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 5px;
    }

    .stock-info.in-stock {
        color: #28a745;
    }

    .stock-info.out-of-stock {
        color: #dc3545;
    }

    .stock-count {
        font-weight: normal;
        color: var(--text-color);
        opacity: 0.7;
    }

    .delivery-info {
        margin-top: 5px;
        width: 100%;
        font-size: 14px;
        font-weight: normal;
        color: var(--text-color);
        opacity: 0.7;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .purchase-options {
        margin: 25px 0;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .quantity-selector label {
        margin-right: 15px;
        font-weight: 500;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        border: 1px solid var(--card-border);
        border-radius: 4px;
        overflow: hidden;
    }

    .quantity-btn {
        background: var(--background-color);
        border: none;
        width: 36px;
        height: 36px;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
        color: var(--text-color);
    }

    .quantity-btn:hover {
        background: var(--button-hover-bg);
    }

    input[type="number"] {
        width: 50px;
        height: 36px;
        border: none;
        border-left: 1px solid var(--card-border);
        border-right: 1px solid var(--card-border);
        text-align: center;
        font-size: 16px;
        -moz-appearance: textfield;
        background-color: var(--card-bg);
        color: var(--text-color);
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .add-to-basket-btn,
    .add-to-wishlist-btn,
    .notify-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        gap: 8px;
        border: none;
    }

    .add-to-basket-btn {
        background-color: var(--heading-color);
        color: white;
    }

    .add-to-basket-btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px var(--card-shadow);
    }

    .add-to-wishlist-btn {
        background-color: var(--card-bg);
        color: var(--heading-color);
        border: 1px solid var(--heading-color);
    }

    .add-to-wishlist-btn:hover {
        background-color: var(--background-color);
        transform: translateY(-2px);
    }

    .notify-btn {
        background-color: var(--background-color);
        color: var(--text-color);
        border: 1px solid var(--card-border);
        width: 100%;
    }

    .notify-btn:hover {
        background-color: var(--button-hover-bg);
    }

    .product-description {
        margin: 30px 0;
        line-height: 1.6;
    }

    .product-description h2 {
        font-size: 18px;
        color: var(--text-color);
        margin-bottom: 15px;
        padding-bottom: 10px;
    }

    .supplier-info {
        margin-top: 20px;
        font-size: 14px;
        color: var(--text-color);
        opacity: 0.7;
    }

    .reviews-section {
        margin: 50px 0;
        padding: 30px;
        background-color: var(--card-bg);
        border-radius: 8px;
        box-shadow: 0 2px 10px var(--card-shadow);
    }

    .reviews-section h2 {
        margin-top: 0;
        margin-bottom: 25px;
        font-size: 24px;
        color: var(--heading-color);
    }

    .reviews-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .average-rating {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .big-rating {
        font-size: 48px;
        font-weight: bold;
        color: var(--heading-color);
    }

    .review-count {
        color: var(--text-color);
        opacity: 0.7;
        font-size: 14px;
    }

    .write-review-cta {
        align-self: flex-start;
    }

    .write-review-btn {
        padding: 10px 20px;
        background-color: var(--heading-color);
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
    }

    .write-review-btn:hover {
        opacity: 0.9;
    }

    .review-form-container {
        background-color: var(--background-color);
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px var(--card-shadow);
        display: none;
    }

    .review-form-container.active {
        display: block;
    }

    .review-form-container h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 18px;
        color: var(--heading-color);
    }

    .alert {
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }

    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    .rating-input {
        margin-bottom: 20px;
    }

    .rating-input label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
        color: var(--text-color);
    }

    .star-rating {
        display: flex;
        gap: 5px;
        margin-bottom: 10px;
    }

    .star {
        font-size: 26px;
        cursor: pointer;
        color: #ddd;
        transition: color 0.2s;
    }

    .star:hover,
    .star.active {
        color: #ffb31a;
    }

    #rating-value {
        margin-top: 10px;
        font-size: 14px;
        color: var(--text-color);
        opacity: 0.7;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
        color: var(--text-color);
    }

    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--card-border);
        border-radius: 4px;
        font-family: inherit;
        font-size: 16px;
        resize: vertical;
        transition: border-color 0.2s;
        background-color: var(--card-bg);
        color: var(--text-color);
    }

    .form-group textarea:focus {
        border-color: var(--heading-color);
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 120, 215, 0.2);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .cancel-btn,
    .submit-btn {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 500;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .cancel-btn {
        background-color: var(--card-bg);
        color: var(--text-color);
        border: 1px solid var(--card-border);
    }

    .submit-btn {
        background-color: var(--heading-color);
        color: white;
        border: none;
    }

    .cancel-btn:hover {
        background-color: var(--button-hover-bg);
    }

    .submit-btn:hover {
        opacity: 0.9;
    }

    .reviews-container {
        margin-top: 30px;
    }

    .review-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-height: 600px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .review-item {
        background-color: var(--background-color);
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 5px var(--card-shadow);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .star-rating-display {
        color: #ffb31a;
        font-size: 16px;
        letter-spacing: 2px;
    }

    .review-date {
        color: var(--text-color);
        opacity: 0.7;
        font-size: 14px;
    }

    .review-content {
        line-height: 1.6;
        color: var(--text-color);
    }

    .no-reviews {
        padding: 30px;
        text-align: center;
        background-color: var(--background-color);
        border-radius: 8px;
        color: var(--text-color);
        opacity: 0.7;
    }

    .related-products {
        margin-top: 50px;
    }

    .related-products h2 {
        font-size: 24px;
        color: var(--heading-color);
        margin-bottom: 25px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }

    .product-card {
        background-color: var(--card-bg);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px var(--card-shadow);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px var(--card-shadow);
    }

    .product-card a {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .product-card-image {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background-color: var(--background-color);
    }

    .product-card-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        background-color: white;
        border-radius: 4px;
    }

    .product-card-content {
        padding: 20px;
    }

    .product-card-content h3 {
        font-size: 16px;
        color: var(--text-color);
        margin-top: 0;
        margin-bottom: 10px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .product-card-content .price {
        font-size: 18px;
        font-weight: bold;
        color: var(--heading-color);
        margin-bottom: 15px;
    }

    .product-card-cta {
        display: inline-block;
        font-size: 14px;
        font-weight: 500;
        color: var(--heading-color);
        margin-top: 10px;
        position: relative;
    }

    .product-card-cta::after {
        content: "→";
        margin-left: 5px;
        transition: transform 0.2s;
    }

    .product-card:hover .product-card-cta::after {
        transform: translateX(5px);
    }

    .notification-toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: var(--card-bg);
        border-radius: 8px;
        box-shadow: 0 5px 15px var(--card-shadow);
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 350px;
        transform: translateY(150%);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
        z-index: 1000;
    }

    .notification-toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    .notification-toast.success {
        border-left: 5px solid #28a745;
    }

    .notification-toast.error {
        border-left: 5px solid #dc3545;
    }

    .notification-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notification-icon {
        font-size: 24px;
    }

    .notification-toast.success .notification-icon {
        color: #28a745;
    }

    .notification-toast.error .notification-icon {
        color: #dc3545;
    }

    #notification-message {
        font-size: 14px;
        color: var(--text-color);
    }

    .close-notification {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        color: var(--text-color);
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .close-notification:hover {
        opacity: 1;
    }

    @media (max-width: 992px) {
        .product-main {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .product-gallery {
            position: static;
        }

        .reviews-summary {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 768px) {
        .breadcrumb {
            font-size: 12px;
        }

        .product-info h1 {
            font-size: 24px;
        }

        .current-price {
            font-size: 26px;
        }

        .action-buttons {
            grid-template-columns: 1fr;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .product-container {
            padding: 0 15px;
        }

        .reviews-section,
        .product-info {
            padding: 20px 15px;
        }

        .product-card-image {
            height: 150px;
        }
    }

    .review-list::-webkit-scrollbar {
        width: 8px;
    }

    .review-list::-webkit-scrollbar-track {
        background: var(--background-color);
        border-radius: 10px;
    }

    .review-list::-webkit-scrollbar-thumb {
        background: var(--card-border);
        border-radius: 10px;
    }

    .review-list::-webkit-scrollbar-thumb:hover {
        background: var(--text-color);
        opacity: 0.5;
    }
</style>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const quantityInput = document.getElementById('quantity');
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');

        if (quantityInput && minusBtn && plusBtn) {
            minusBtn.addEventListener('click', function () {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > parseInt(quantityInput.min)) {
                    quantityInput.value = currentValue - 1;
                }
            });

            plusBtn.addEventListener('click', function () {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue < parseInt(quantityInput.max)) {
                    quantityInput.value = currentValue + 1;
                }
            });

            quantityInput.addEventListener('input', function () {
                let value = parseInt(this.value);
                const min = parseInt(this.min);
                const max = parseInt(this.max);

                if (isNaN(value) || value < min) {
                    this.value = min;
                } else if (value > max) {
                    this.value = max;
                }
            });
        }

        const writeReviewBtn = document.getElementById('write-review-btn');
        const reviewFormContainer = document.getElementById('review-form-container');
        const cancelReviewBtn = document.getElementById('cancel-review');

        if (writeReviewBtn && reviewFormContainer && cancelReviewBtn) {
            writeReviewBtn.addEventListener('click', function () {
                reviewFormContainer.classList.add('active');
                writeReviewBtn.style.display = 'none';

                reviewFormContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });

            cancelReviewBtn.addEventListener('click', function () {
                reviewFormContainer.classList.remove('active');
                writeReviewBtn.style.display = 'flex';
            });
        }

        const stars = document.querySelectorAll('.star-rating .star');
        const ratingValueSpan = document.querySelector('#rating-value span');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const value = parseInt(this.getAttribute('data-value'));
                document.cookie = "rating=" + value + "; path=/";

                stars.forEach(s => {
                    const starValue = parseInt(s.getAttribute('data-value'));
                    if (starValue <= value) {
                        s.classList.add('active');
                        s.querySelector('i').classList.remove('bi-star');
                        s.querySelector('i').classList.add('bi-star-fill');
                    } else {
                        s.classList.remove('active');
                        s.querySelector('i').classList.remove('bi-star-fill');
                        s.querySelector('i').classList.add('bi-star');
                    }
                });

                if (ratingValueSpan) {
                    ratingValueSpan.textContent = value;
                }
            });

            star.addEventListener('mouseover', function () {
                const value = parseInt(this.getAttribute('data-value'));

                stars.forEach(s => {
                    const starValue = parseInt(s.getAttribute('data-value'));
                    if (starValue <= value) {
                        s.querySelector('i').classList.remove('bi-star');
                        s.querySelector('i').classList.add('bi-star-fill');
                    } else {
                        s.querySelector('i').classList.remove('bi-star-fill');
                        s.querySelector('i').classList.add('bi-star');
                    }
                });
            });

            star.addEventListener('mouseout', function () {
                stars.forEach(s => {
                    const isActive = s.classList.contains('active');
                    if (isActive) {
                        s.querySelector('i').classList.remove('bi-star');
                        s.querySelector('i').classList.add('bi-star-fill');
                    } else {
                        s.querySelector('i').classList.remove('bi-star-fill');
                        s.querySelector('i').classList.add('bi-star');
                    }
                });
            });
        });

        const productImage = document.getElementById('main-product-image');
        if (productImage) {
            productImage.addEventListener('mousemove', function (e) {
                const { left, top, width, height } = this.getBoundingClientRect();
                const x = (e.clientX - left) / width;
                const y = (e.clientY - top) / height;

                this.style.transformOrigin = `${x * 100}% ${y * 100}%`;
            });
        }
    });

    async function addToBasket(productId, quantity) {
        try {
            quantity = parseInt(quantity) || 1;
            const Data_Basket = {
                id: productId,
                quantity: quantity
            };

            const resp = await fetch('addToBasket.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Data_Basket)
            });

            const data = await resp.json();
            if (data.status === "success") {
                showNotification("Item added to your basket", "success");
            } else {
                showNotification(data.message || "Error adding item to basket", "error");
            }
        } catch (error) {
            console.error("Error:", error);
            showNotification("Error adding item to basket", "error");
        }
    }

    async function addToWishlist(productId) {
        try {
            const Data_Wishlist = { id: productId };

            const resp = await fetch('addToWishlist.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Data_Wishlist)
            });

            const data = await resp.json();
            if (data.status === "success") {
                showNotification("Item added to your wishlist", "success");
            } else {
                showNotification(data.message || "Error adding item to wishlist", "error");
            }
        } catch (error) {
            console.error("Error:", error);
            showNotification("Error adding item to wishlist", "error");
        }
    }

    function showNotification(message, type) {
        const toast = document.getElementById('notification-toast');
        const messageElement = document.getElementById('notification-message');
        const iconElement = document.querySelector('.notification-icon');

        if (toast && messageElement) {
            messageElement.textContent = message;

            toast.className = 'notification-toast';
            toast.classList.add(type);

            if (type === 'success') {
                iconElement.classList.remove('bi-exclamation-circle');
                iconElement.classList.add('bi-check-circle');
            } else {
                iconElement.classList.remove('bi-check-circle');
                iconElement.classList.add('bi-exclamation-circle');
            }

            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);

            const closeBtn = document.querySelector('.close-notification');
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    toast.classList.remove('show');
                });
            }
        }
    }
</script>

<?php 
include 'footer.php'; 
ob_end_flush();
?>