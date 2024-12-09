<?php
require_once("dbconnection.php");
include 'header.php';
?>


<body>

    <h1>Trending Deals</h1>

    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="images/Nitendo deal.jpeg" style="width:50%">
        </div>

        <div class="mySlides fade">
            <img src="images/ps5 deal.png" style="width:50%">
        </div>

        <div class="mySlides fade">
            <img src="images/xbox deal.png" style="width:50%">
        </div>

        <br>

        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>

    <h1>Shop by Brand</h1>

    <div class="section-container">
        <div class="gallery">
            <a href="ps5.php">
                <img src="images/playstation-blue.svg" alt="PlayStation">
            </a>
            <div class="description">PLAYSTATION</div>
            <div class="buttons">
            </div>
        </div>
        <div class="gallery">
            <a href="xbox.php">
                <img src="images/xbox.svg" alt="XBOX">
            </a>
            <div class="description">XBOX</div>
            <div class="buttons">
            </div>
        </div>
        <div class="gallery">
            <a href="nintendo.php">
                <img src="images/nintendo.svg" alt="Nintendo">
            </a>
            <div class="description">NINTENDO</div>
            <div class="buttons">
            </div>
        </div>
        <div class="gallery">
            <a href="VR.php">
                <img src="images/meta.svg" alt="VR">
            </a>
            <div class="description">META QUEST</div>
            <div class="buttons">
            </div>
        </div>
        <div class="gallery">
            <a href="pc.php">
                <img src="images/pc.svg" alt="PC">
            </a>
            <div class="description">PC</div>
            <div class="buttons">
            </div>
        </div>
    </div>

    <h1>New Releases</h1>

    <div class="section-container">
        <div class="gallery">
            <a href="product.php?id=46">
                <img src="images/Trending - Fifa.webp" alt="FC 2025">
            </a>
            <div data-id="46" data-name="FC2025" data-price="69.99" class="description">FC 2025</div>
            <div class="description">£69.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=54">
                <img src="images/Trending - PS PORTAL.webp" alt="PS PORTAL">
            </a>
            <div data-id="54" data-name="PSPORTAL" data-price="199.99" class="description">PS PORTABLE</div>
            <div class="description">£199.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=6">
                <img src="images/Trending - switch.webp" alt="Nintendo Switch">
            </a>
            <div data-id="6" data-name="NintendoSwitch" data-price="199.99" class="description">Nintendo Switch</div>
            <div class="description">£199.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=82">
                <img src="images/New Releases - MQ.webp" alt="Meta Quest">
            </a>
            <div data-id="82" data-name="MetaQuest" data-price="199.99" class="description">Meta Quest</div>
            <div class="description">£199.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>
    </div>

    <h1>Coming Soon</h1>

    <div class="section-container">
        <div class="gallery">
            <a href="product.php?id=5">
                <img src="images/CS - 2K25.avif" alt="2K25">
            </a>
            <div data-id="5" data-name="2K25" data-price="69.99" class="description">2K25</div>
            <div class="description">Pre-order now for £69.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=6">
                <img src="images/CS - B06.avif" alt="Black Ops 6">
            </a>
            <div data-id="6" data-name="PSBlackOps6" data-price="69.99" class="description">PS5 Black ops 6</div>
            <div class="description">Pre-order now for £69.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=7">
                <img src="images/CS - MQ 3 1TB.avif" alt="Meta Quest 3">
            </a>
            <div data-id="7" data-name="MetaQuest3-1TB" data-price="479.99" class="description">Meta Quest 3 1TB</div>
            <div class="description">Pre-order now for £479.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=8">
                <img src="images/CS - XBOX B06.avif" alt="Xbox Black Ops 6">
            </a>
            <div data-id="8" data-name="XBlackOps6" data-price="69.99" class="description">XBOX Black ops 6</div>
            <div class="description">Pre-order now for £69.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>
    </div>

    <h1>Black Friday Deals</h1>

    <div class="section-container">
        <div class="gallery">
            <a href="product.php?id=9">
                <img src="images/GTR Black friday deal.jpg" alt="Gran Turismo">
            </a>
            <div data-id="9" data-name="GranTurismo" data-price="49.99" class="description">Gran Turismo 7</div>
            <div class="description">Was £69.99</div>
            <div class="description">Now £49.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=43">
                <img src="images/PS FORTNITE DEAL.avif" alt="PS5 Fortnite Bundle">
            </a>
            <div data-id="43" data-name="PlayStation5Fortnite" data-price="339.99" class="description">PlayStation 5
                Console Fortnite Bundle</div>
            <div class="description">Was £389.99</div>
            <div class="description">Now £339.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=51">
                <img src="images/PS5 CONTROL ALL BLACK DEAL.avif" alt="PS5 Controller">
            </a>
            <div data-id="51" data-name="PS5BlackController" data-price="29.99" class="description">PS5 all Black
                Controller</div>
            <div class="description">Was £49.99</div>
            <div class="description">Now £29.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=47">
                <img src="images/SpiderMan 2 - Black friday.jpg" alt="Spider-Man 2">
            </a>
            <div class="description" data-id="47" data-name="MarvelSpiderman2" data-price="49.99" >Marvel SpiderMan 2
            </div>
            <div class="description">Was £69.99</div>
            <div class="description">Now £49.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>
    </div>

    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 2000); // Change image every 2 seconds
        }

        async function addToBasket(button) {
            try {
                const gallery = button.closest('.gallery');
                if (!gallery) {
                    throw new Error("Gallery container not found");
                }
                const description = gallery.querySelector('div[data-id]');
                if (!description) {
                    throw new Error("Product data not found");
                }
                const id = description.getAttribute('data-id');
                if (!id) {
                    throw new Error("Product ID not found");
                }
                const Data_Basket = { id: id };
                const resp = await fetch('/addToBasket.php', {
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

        async function addToWishlist(button) {
            const gallery = button.closest('.gallery');
            const description = gallery.querySelector('.description[data-id]');
            const id = description.getAttribute('data-id');
            const Data_Wishlist = { id: id.querySelector("a").getAttribute("href").split("data-id=")[1] };
            try {
                const resp = await fetch('addToWishlist.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(Data_Wishlist)
                });
                const data = await resp.json();
                if (data.status === "success") {
                    alert("Item has been added to wishlist");
                } else {
                    alert("error : " + data.message);
                }
            } catch (error) {
                console.error("error : " + error);
            }
        }
    </script>

    <!-- Footer -->
    <footer class="footer-container">
        <!-- Newsletter Section -->
        <div class="newsletter-section">
            <h2>Dont Miss Out</h2>
            <p>Sign up for the latest Tech news and offers!</p>

            <form class="signup-form">
                <div class="form-group">
                    <label for="email">EMAIL ADDRESS*</label>
                    <input type="email" id="email" placeholder="Enter Your Email Address" required>
                </div>
                <button type="submit" class="signup-button">SIGN UP</button>
            </form>

            <p class="disclaimer">*By signing up, you understand and agree that your data will be collected and used
                subject to our Privacy Policy and Terms of Use.</p>

            <div class="social-icons">
                <a href="https://www.instagram.com/" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://www.facebook.com/" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://x.com/" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="https://youtube.com/" aria-label="Youtube"><i class="bi bi-youtube"></i></a>
                <a href="https://uk.pinterest.com/" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="footer-links">
            <div class="footer-column">
                <h3>COMPANY</h3>
                <ul>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="experts.php">Experts and Spokemodels</a></li>
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
            <a href="homepage.php" class="back-to-top-button">BACK TO TOP ↑</a>
        </div>
    </footer>

</body>

</html>