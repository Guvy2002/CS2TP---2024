<?php
require_once 'dbconnection.php';
include 'header.php';
?>
<div class="video-container">
    <video autoplay muted loop>
        <source src="images/xbox.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </>video
</div>

<?php include("sort.php"); ?>

<?php
$categories = [
    "XBOX CONSOLES" => "14",
    "LATEST XBOX GAMES" => "15",
    "XBOX ACCESSORIES" => "16",
    "XBOX DIGITAL" => "17"
];

foreach ($categories as $title => $category) {
    echo "<h1>$title</h1>";
    echo "<div class='section-container'>";
    
    $stmt = $conn->prepare("SELECT * FROM Products WHERE categoryID = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        echo "<div class='gallery'>
                <a href='product.php?id={$row['productID']}'>
                    <img src='{$row['imgURL']}' alt='{$row['fullName']}'>
                    <div data-id='{$row['productID']}' data-name='{$row['fullName']}' data-price='{$row['Price']}' class='description'>{$row['fullName']}</div>
                    <div class='description'>£{$row['Price']}</div>
                </a>
                <div class='buttons'>
                    <button onclick='addToBasket(this)' class='btn add-to-basket'>Add to Basket</button>
                    <button onclick='addToWishlist(this)' class='btn add-to-wishlist'>Add to Wishlist</button>
                </div>
              </div>";
    }
    
    echo "</div>";
}
?>

<?php include 'footer.php'; ?>
</body>

</html>
