<?php
require_once 'dbconnection.php';
ob_start();
include 'header.php';
?>
<body>
<?php

$categories = [
    "XBOX CONSOLES" => "14",
    "LATEST XBOX GAMES" => "15",
    "XBOX ACCESSORIES" => "16",
    "XBOX DIGITAL" => "17"
];

include 'filters.php'; 
?>

<div class="video-container">
    <video autoplay muted loop>
        <source src="images/xbox.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<?php
include 'sort.php';

foreach ($categories as $title => $category) {
    echo "<h1>$title</h1>";
    echo "<div class='section-container'>";
    
    $stmt = getFilteredProducts($category, $conn);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='gallery'>
                    <a href='product.php?id={$row['productID']}'>
                        <img src='{$row['imgURL']}' alt='{$row['fullName']}'>
                    </a>
                    <div data-id='{$row['productID']}' data-name='{$row['fullName']}' data-price='{$row['Price']}' class='description'>{$row['fullName']}</div>
                    <div class='description'>£{$row['Price']}</div>
                    <div class='buttons'>
                        <button onclick='addToBasket(this)' class='btn add-to-basket'>Add to Basket</button>
                        <button onclick='addToWishlist(this)' class='btn add-to-wishlist'>Add to Wishlist</button>
                    </div>
                  </div>";
        }
    } else {
        echo "<p class='no-products'>No products found matching your filters.</p>";
    }
    
    echo "</div>";
}
?>

<?php 
include 'footer.php';
ob_end_flush();
?>

</body>