<?php
require_once 'dbconnection.php';
include 'header.php';
?>

<body>

    <div class="video-container">
        <video autoplay muted loop>
            <source src="images/vr.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <?php include("sort.php"); ?>

    <?php
    function fetchProducts($categoryID, $conn) {
        $stmt = $conn->prepare("SELECT productID, fullName, Price, imgURL FROM Products WHERE categoryID = ?");
        $stmt->bind_param("s", $categoryID);
        $stmt->execute();
        return $stmt->get_result();
    }

    $categories = [
        "FEATURED VR HEADSETS & BUNDLES" => "18",
        "LATEST VR GAMES" => "19",
        "VR ACCESSORIES" => "20"
    ];

    foreach ($categories as $title => $categoryID) :
        $products = fetchProducts($categoryID, $conn);
    ?>
        <h1><?php echo $title; ?></h1>
        <div class="section-container">
            <?php while ($row = $products->fetch_assoc()) : ?>
                <div class="gallery">
                    <a href="product.php?id=<?php echo $row['productID']; ?>">
                        <img src="<?php echo $row['imgURL']; ?>" alt="<?php echo htmlspecialchars($row['fullName']); ?>">
                    </a>
                    <div data-id="<?php echo $row['productID']; ?>" class="description"><?php echo htmlspecialchars($row['fullName']); ?></div>
                    <div class="description">£<?php echo number_format($row['Price'], 2); ?></div>
                    <div class="buttons">
                        <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                        <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endforeach; ?>

    <?php include 'footer.php'; ?>
</body>
</html>
