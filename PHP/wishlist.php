<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('dbconnection.php');
ob_start();
include 'header.php';

if (!isset($conn)) {
    die("Database connection failed.");
}
?>

<div class="page-container">
    <div class="main-content">
        <div class="wishlist-container">
            <h1>Your Wishlist</h1>
            <?php
            if (!isset($_SESSION["customerID"])) {
                echo '<div class="empty-wishlist-message">Please log in to view your wishlist</div>';
            } else {
                $customerID = $_SESSION["customerID"];
                $wishlistQuery = "SELECT b.wishlistID, bi.productID, p.fullName, p.Price, p.imgURL 
                           FROM Wishlist b
                           LEFT JOIN WishlistItem bi ON b.wishlistID = bi.wishlistID
                           LEFT JOIN Products p ON bi.productID = p.productID
                           WHERE b.customerID = ?
                           ORDER BY b.createdDate DESC";
                $stmt = $conn->prepare($wishlistQuery);
                if ($stmt === false) {
                    die('prepare() failed: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param("i", $customerID);
                $stmt->execute();
                $result = $stmt->get_result();
                
                $wishlistIsEmpty = true;
                while ($row = $result->fetch_assoc()) {
                    if ($row['productID'] !== null) {
                        $wishlistIsEmpty = false;
                        ?>
                        <div class="wishlist-item"
                             data-wishlist-id="<?php echo htmlspecialchars($row['wishlistID']); ?>"
                             data-product-id="<?php echo htmlspecialchars($row['productID']); ?>">
                            <img src="<?php echo htmlspecialchars($row['imgURL']); ?>"
                                 alt="<?php echo htmlspecialchars($row['fullName']); ?>">
                            <div class="item-details">
                                <div class="item-title"><?php echo htmlspecialchars($row['fullName']); ?></div>
                                <div class="item-price">£<?php echo number_format($row['Price'], 2); ?></div>
                            </div>
                            <button onclick="removeItem(this)" class="remove-button">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button onclick="addToBasket(this)" class="basket-button">
                                <i class="bi bi-cart3"></i>
                            </button>
                        </div>
                        <?php
                    }
                }
                if ($wishlistIsEmpty) {
                    echo '<div class="empty-wishlist-message">Your wishlist is empty</div>';
                }
            }
            ?>
        </div>
    </div>
</div>
            

<?php 
include 'footer.php'; 
ob_end_flush();
?> 

<style>
    html, body {
        height: 100%;
        margin: 0;
    }
    .page-container {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .main-content {
        flex: 1;
    }
    .footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px;
        margin-top: auto;
    }
</style>

 <script>
    async function removeItem(buttonOrData) {
        try {
            const container = buttonOrData.closest('.wishlist-item');
            const productId = container.dataset.productId;
            const wishlistId = container.dataset.wishlistId;
            if (!wishlistId || !productId) {
                throw new Error("Required IDs not found");
            }
            const Data_Wishlist = { id: productId, wishlist_id: wishlistId };
            const resp = await fetch('/removeFromWishlist.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Data_Wishlist)
            });
            const data = await resp.json();
            if (data.status === "success") {
                container.remove();
                checkEmptyWishlist();
            } else {
                console.error(data.message || "Error removing item from wishlist");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }

      async function addToBasket(button) {
        try {
            const container = button.closest('.wishlist-item');
            const productId = container.dataset.productId;
            const wishlistId = container.dataset.wishlistId;
            if (!productId || !wishlistId) {
                throw new Error("Required IDs not found");
            }
            const Data_Basket = { id: productId };
            const resp = await fetch('/addToBasket.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Data_Basket)
            });
            const data = await resp.json();
            if (data.status === "success") {
                removeItem(button);
            } else {
                console.error(data.message || "Error adding item to basket");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }

    function checkEmptyWishlist() {
        if (document.querySelectorAll('.wishlist-item').length === 0) {
            document.querySelector('.wishlist-container').innerHTML += '<div class="empty-wishlist-message">Your wishlist is empty</div>';
        }
    }
</script>