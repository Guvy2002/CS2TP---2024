<?php
ob_start();
require_once("dbconnection.php");
include 'header.php';

function fetchProducts($categoryID, $limit = 3) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM Products WHERE categoryID = ? LIMIT ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error); 
    }

    $stmt->bind_param("ii", $categoryID, $limit);
    $stmt->execute();

    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    return $products;
}
?>

<main class="main-content">
    <h1>Trending Deals</h1>
    <div class="slideshow-container">
        <div class="mySlides active">
            <img src="images/Nitendo deal.jpeg" alt="Nintendo Deal">
        </div>
        <div class="mySlides">
            <img src="images/ps5 deal.png" alt="PS5 Deal">
        </div>
        <div class="mySlides">
            <img src="images/xbox deal.png" alt="Xbox Deal">
        </div>
        <div class="dots-container">
            <span class="dot active" data-index="0"></span>
            <span class="dot" data-index="1"></span>
            <span class="dot" data-index="2"></span>
        </div>
    </div>

    <?php include("sort.php"); ?>

    <?php
    $categories = [
        "Nintendo" => ["1", "2", "3", "4"],
        "PC" => ["5", "6", "7", "8", "9"], 
        "PS5" => ["10", "11", "12", "13"],  
        "XBOX" => ["14", "15", "16", "17"],
        "VR" => ["18", "19", "20"]  
    ];

    foreach ($categories as $title => $categoryIDs) {
        $randomCategoryID = $categoryIDs[array_rand($categoryIDs)];
        $products = (fetchProducts($randomCategoryID, 3));

        if (!empty($products)) {
            echo "<h1>$title</h1>";
            echo "<div class='section-container'>";
            foreach ($products as $product) {
                echo "<div class='gallery'>
                    <a href='product.php?id={$product['productID']}'>
                        <img src='{$product['imgURL']}' alt='{$product['fullName']}'>
                    </a>
                    <div class='description' data-id='{$product['productID']}' data-name='{$product['fullName']}' data-price='{$product['Price']}'>
                        {$product['fullName']}
                    </div>
                    <div class='description'>£" . number_format($product['Price'], 2) . "</div>
                    <div class='buttons'>
                        <button onclick='addToBasket(this)' class='btn add-to-basket'>Add to Basket</button>
                        <button onclick='addToWishlist(this)' class='btn add-to-wishlist'>Add to Wishlist</button>
                    </div>
                </div>";
            }
            echo "</div>";
        } else {
            echo "<p>No products found in $title category.</p>";
        }
    }
    ?>
</main>

<script>
    class Slideshow {
        constructor() {
            this.slideIndex = 0;
            this.slides = document.getElementsByClassName("mySlides");
            this.dots = document.getElementsByClassName("dot");
            this.intervalDuration = 5000;
            this.setupEventListeners();
            this.startSlideshow();
            this.showSlide(0);
        }

        setupEventListeners() {
            Array.from(this.dots).forEach((dot, index) => {
                dot.addEventListener('click', () => this.showSlide(index));
            });
        }

        showSlide(n) {
            Array.from(this.slides).forEach(slide => slide.classList.remove('active'));
            Array.from(this.dots).forEach(dot => dot.classList.remove('active'));

            this.slideIndex = n;
            if (this.slideIndex >= this.slides.length) this.slideIndex = 0;
            if (this.slideIndex < 0) this.slideIndex = this.slides.length - 1;

            this.slides[this.slideIndex].classList.add('active');
            this.dots[this.slideIndex].classList.add('active');
        }

        changeSlide(direction) {
            this.showSlide(this.slideIndex + direction);
        }

        startSlideshow() {
            setInterval(() => {
                this.changeSlide(1);
            }, this.intervalDuration);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        new Slideshow();
    });
</script>

<?php include 'footer.php'; 
ob_end_flush();
?>