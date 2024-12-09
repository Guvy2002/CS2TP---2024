<?php
require_once 'dbconnection.php';
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$productId) {
    header('Location: 404.php');
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
    header('Location: 404.php');
    exit();
}
$sql = "SELECT * FROM Products 
        WHERE categoryID = ? AND productID != ? 
        LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $product['categoryID'], $productId);
$stmt->execute();
$relatedProducts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
include 'header.php';
?>

<div class="product-container">
    <div class="breadcrumb">
        <a href="homepage.php">Home</a> >
        <a <?php echo $product['categoryID']; ?>>
            <?php echo htmlspecialchars($product['categoryName']); ?>
        </a> >
        <?php echo htmlspecialchars($product['fullName']); ?>
    </div>
    <div class="product-main">
        <div class="product-gallery">
            <div class="main-image-container">
                <img src="<?php echo htmlspecialchars($product['imgURL']); ?>" 
                     alt="<?php echo htmlspecialchars($product['fullName']); ?>" 
                     id="main-product-image">
            </div>
        </div>
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['fullName']); ?></h1>
            <p class="model-no">Model: <?php echo htmlspecialchars($product['ModelNo']); ?></p>
            <div class="price-section">
                <div class="price-container">
                    <span class="current-price">£<?php echo number_format($product['Price'], 2); ?></span>
                </div>
                <div class="stock-info">
                    <?php if($product['stockQuantity'] > 0): ?>
                        <i class="bi bi-check-circle-fill"></i> In Stock (<?php echo $product['stockQuantity']; ?> available)
                        <p>FREE Next Day Delivery</p>
                    <?php else: ?>
                        <i class="bi bi-x-circle-fill"></i> Out of Stock
                    <?php endif; ?>
                </div>
            </div>
            <div class="purchase-options">
                <?php if($product['stockQuantity'] > 0): ?>
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <select id="quantity" name="quantity">
                            <?php for($i = 1; $i <= min(10, $product['stockQuantity']); $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button class="add-to-basket-btn" 
                            onclick="addToBasket(<?php echo $product['productID']; ?>, '<?php echo $product['fullName']; ?>', <?php echo $product['Price']; ?>)">
                        Add to Basket
                    </button>
                    <button class="add-to-wishlist-btn"
                            onclick="addToWishlist(<?php echo $product['productID']; ?>, '<?php echo $product['fullName']; ?>', <?php echo $product['Price']; ?>)">
                        Add to Wishlist
                    </button>
                <?php else: ?>
                    <button class="notify-btn">Notify When Available</button>
                <?php endif; ?>
            </div>
            <?php if(!empty($product['Description'])): ?>
                <div class="product-description">
                    <h2>Product Description</h2>
                    <p><?php echo nl2br(htmlspecialchars($product['Description'])); ?></p>
                </div>
            <?php endif; ?>
            <?php if($product['Supplier']): ?>
                <div class="supplier-info">
                    <p>Supplied by: <?php echo htmlspecialchars($product['Supplier']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if(!empty($relatedProducts)): ?>
        <div class="related-products">
            <h2>Related Products</h2>
            <div class="products-grid">
                <?php foreach($relatedProducts as $related): ?>
                    <div class="product-card">
                        <a href="product.php?id=<?php echo $related['productID']; ?>">
                            <img src="<?php echo htmlspecialchars($related['imgURL']); ?>" 
                                 alt="<?php echo htmlspecialchars($related['fullName']); ?>">
                            <h3><?php echo htmlspecialchars($related['fullName']); ?></h3>
                            <div class="price">£<?php echo number_format($related['Price'], 2); ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<style>
.product-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 0 20px;
}

.breadcrumb {
    margin-bottom: 20px;
    font-size: 14px;
}

.breadcrumb a {
    color: #0066cc;
    text-decoration: none;
}

.product-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
}

.main-image-container img {
    width: 100%;
    height: auto;
}

.product-info h1 {
    margin-bottom: 10px;
    font-size: 24px;
}

.model-no {
    color: #666;
    margin-bottom: 20px;
}

.price-section {
    margin: 20px 0;
}

.current-price {
    font-size: 28px;
    font-weight: bold;
}

.stock-info {
    margin: 10px 0;
    color: #007700;
}

.stock-info i {
    margin-right: 5px;
}

.quantity-selector {
    margin: 20px 0;
}

.quantity-selector select {
    padding: 5px;
    margin-left: 10px;
}

.add-to-basket-btn, .add-to-wishlist-btn {
    display: block;
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.add-to-basket-btn {
    background-color: #0066cc;
    color: white;
}

.add-to-wishlist-btn {
    background-color: #fff;
    border: 1px solid #0066cc;
    color: #0066cc;
}

.product-description {
    margin: 30px 0;
}

.related-products {
    margin-top: 40px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.product-card {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.product-card img {
    max-width: 100%;
    height: auto;
}

.product-card a {
    text-decoration: none;
    color: inherit;
}

@media (max-width: 768px) {
    .product-main {
        grid-template-columns: 1fr;
    }

    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
async function addToBasket(productId, productName, productPrice) {
    try {
        const Data_Basket = { id: productId };
        const resp = await fetch('addToBasket.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(Data_Basket)
        });
        const data = await resp.json();
        if (data.status === "success") {
            alert("Item has been added to basket");
        } else {
            alert(data.message || "Error adding item to basket");
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error adding item to basket: " + error.message);
    }
}

async function addToWishlist(productId, productName, productPrice) {
    try {
        const Data_Wishlist = { id: productId };
        const resp = await fetch('addToWishlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(Data_Wishlist)
        });
        const data = await resp.json();
        if (data.status === "success") {
            alert("Item has been added to wishlist");
        } else {
            alert("Error: " + data.message);
        }
    } catch (error) {
        console.error("Error: " + error);
        alert("Error adding item to wishlist");
    }
}
</script>

<?php
include 'footer.php';
?>