<?php 
require_once 'dbconnection.php';
include 'header.php';

$query = "SELECT * FROM Products";
$result = $conn->query($query);
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$categories = [
    "Nintendo Consoles" => [],
    "Latest Nintendo Games" => [],
    "Nintendo Controllers" => [],
    "Nintendo Digital" => []
];

foreach ($products as $product) {
    switch ($product['categoryID']) {
        case "2":
            $categories["Nintendo Consoles"][] = $product;
            break;
        case "1":
            $categories["Latest Nintendo Games"][] = $product;
            break;
        case "3":
            $categories["Nintendo Controllers"][] = $product;
            break;
        case "4":
            $categories["Nintendo Digital"][] = $product;
            break;
    }
}
?>

<div class="video-container">
    <video autoplay muted loop>
        <source src="images/nintendo.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<?php include("sort.php"); ?>

<?php foreach ($categories as $category => $items): ?>
    <h1><?= htmlspecialchars($category) ?></h1>
    <div class="section-container">
        <?php foreach ($items as $product): ?>
            <div class="gallery">
                <a href="product.php?id=<?= $product['productID'] ?>">
                    <img src="<?= htmlspecialchars($product['imgURL']) ?>" alt="<?= htmlspecialchars($product['fullName']) ?>">
                    <div data-id="<?= $product['productID'] ?>" data-name="<?= htmlspecialchars($product['fullName']) ?>" data-price="<?= $product['Price'] ?>" class="description"> <?= htmlspecialchars($product['fullName']) ?></div>
                    <div class="description">£<?= number_format($product['Price'], 2) ?></div>
                </a>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?php include 'footer.php'; ?>
</body>

</html>
