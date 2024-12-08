<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="ps5styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
</head>

<body>
<div class="grad3">
    <img src="images/GamePointLogo.png" class="logo" alt="GamePoint Logo">
    <h2>GamePoint</h2>
</div>

<style>
    .grad3 {
        height: 100px;
        background-color: red;
        /* For browsers that do not support gradients */
        background-image: linear-gradient(180deg, rgb(49, 43, 43), rgb(248, 244, 249));
    }
</style>

<div class="navbar">
    <ul>
        <li><a href="homepage.html">Home</a></li>
        <li><a href="ps5.html">PlayStation</a></li>
        <li><a href="xbox.html">XBOX</a></li>
        <li><a href="nintendo.html">Nintendo</a></li>
        <li><a href="VR.html">VR</a></li>
        <li><a href="pc.html">PC</a></li>
        <li><a href="sb.html">Special Bundles</a></li>
        <li><a href="preorder.html">Pre order</a></li>
    </ul>

    <!-- Right Section: Sign In and Basket -->
    <div class="right-section">
        <div class="search-box">
            <input type="text" class="search-bar" placeholder="Search...">
            <button class="search-button">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <a href="wishlist.html">
            <i class="bi bi-heart"></i>
        </a>
        <a href="basket.html">
            <i class="bi bi-cart3"></i>
        </a>
        <a href="login.html">
            <i class="bi bi-person-circle"></i>
        </a>
    </div>
</div>

<section class="wishlist-container">
    <h1>Your Wishlist</h1>
    <p class="text">Here are the items you've saved to your wishlist:</p>

    <div class="wishlist-item">
        <a target="_blank" href="images/c1.png">
            <img src="images/c1.png" alt="Playstation 6"></a>
        <div class="item-details">
            <div class="item-title">Playstation 6</div>
            <div class="item-price">£499.99</div>
            <div class="release-date">Release Date: 15 September 2025</div>
            <div class="delivery-estimate">Delivery: 7-14 Days</div>
            <div class="quantity-controls">
                <button class="quantity-btn">
                    <i class="bi bi-dash-square-fill"></i>
                </button>
                <span>1</span>
                <button class="quantity-btn">
                    <i class="bi bi-plus-square-fill"></i>
                </button>
                <button class="btn add-to-basket">Add to Basket</button>
            </div>
        </div>
        <button class="remove-button"> HERE
            <i class="bi bi-trash"></i>
        </button>
    </div>

    <div class="wishlist-item">
        <a target="_blank" href="images/xboxa.png">
            <img src="images/xboxa.png" alt="Xbox Series X with FC 24 game"></a>
        <div class="item-details">
            <div class="item-title">Xbox Series X with FC 24 game</div>
            <div class="item-price">£499.99</div>
            <div class="quantity-controls">
                <button class="quantity-btn">
                    <i class="bi bi-dash-square-fill"></i>
                </button>
                <span>1</span>
                <button class="quantity-btn">
                    <i class="bi bi-plus-square-fill"></i>
                </button>
                <button class="btn add-to-basket">Add to Basket</button>
            </div>
        </div>
        <button class="remove-button">
            <i class="bi bi-trash"></i>
        </button>
    </div>

</section>

<!-- Footer -->
<footer class="footer-container">
    <!-- Newsletter Section -->
    <div class="newsletter-section">
        <h2>Don't Miss Out</h2>
        <p>Sign up for the latest Tech news and offers!</p>

        <form class="signup-form">
            <div class="form-group">
                <label for="email">EMAIL ADDRESS*</label>
                <input type="email" id="email" placeholder="Enter Your Email Address" required>
            </div>
            <button type="submit" class="signup-button">SIGN UP</button>
        </form>

        <p class="disclaimer"> *By signing up, you understand and agree that your data will be collected and used
            subject to our Privacy Policy and Terms of Use.</p>

        <div class="social-icons">
            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" aria-label="Youtube"><i class="bi bi-youtube"></i></a>
            <a href="#" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
        </div>
    </div>

    <!-- Footer Links -->
    <div class="footer-links">
        <div class="footer-column">
            <h3>COMPANY</h3>
            <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Experts and Spokemodels</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>CUSTOMER SERVICE</h3>
            <ul>
                <li><a href="contactus.html">Contact Us</a></li>
                <li><a href="#">My Account</a></li>
                <li><a href="#">Store Location</a></li>
                <li><a href="#">Redeem rewards</a></li>
            </ul>
        </div>
    </div>

    <!-- Back to Top Button -->
    <div class="back-to-top-container">
        <a href="wishlist.html" class="back-to-top-button">BACK TO TOP ↑</a>
    </div>
</footer>

<script>
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function () {
            const quantitySpan = this.parentElement.querySelector('span');
            let quantity = parseInt(quantitySpan.textContent);

            // Check if it's plus or minus button
            if (this.querySelector('.bi-plus-square-fill')) {
                quantity++;
            } else if (this.querySelector('.bi-dash-square-fill') && quantity > 1) {
                quantity--;
            }

            // Update the displayed quantity
            quantitySpan.textContent = quantity;

            // Update totals
            updateTotals();
        });
    });

    document.querySelectorAll('.remove-button').forEach(button => {
        button.addEventListener('click', function () {
            const basketItem = this.closest('.basket-item');
            basketItem.style.transition = 'opacity 0.3s ease';
            basketItem.style.opacity = '0';
            setTimeout(() => {
                basketItem.remove();
                updateTotals();
                const remainingItems = document.querySelectorAll('.basket-item');
                if (remainingItems.length === 0) {
                    const basketContainer = document.querySelector('.basket-container');
                    const emptyMessage = document.createElement('div');
                    emptyMessage.textContent = 'Your basket is empty';
                    emptyMessage.style.textAlign = 'center';
                    emptyMessage.style.padding = '20px';
                    emptyMessage.style.fontSize = '18px';
                    basketContainer.insertBefore(emptyMessage, document.querySelector('.basket-summary'));
                }
            }, 300);
        });
    });
</script>
</body>

</html>
