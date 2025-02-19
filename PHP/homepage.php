<?php
require_once("dbconnection.php");
include 'header.php';

?>


<body>
    <main class="main-content">
        <h1>Trending Deals</h1>

        <div class="slideshow-container">
            <div class="mySlides">
                <img src="images/Nitendo deal.jpeg" alt="Nintendo Deal">
            </div>

            <div class="mySlides">
                <img src="images/ps5 deal.png" alt="PS5 Deal">
            </div>

            <div class="mySlides">
                <img src="images/xbox deal.png" alt="Xbox Deal">
            </div>

            <!-- Dots Navigation -->
            <div class="dots-container">
                <span class="dot" data-index="0"></span>
                <span class="dot" data-index="1"></span>
                <span class="dot" data-index="2"></span>
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
                <div data-id="6" data-name="NintendoSwitch" data-price="199.99" class="description">Nintendo Switch
                </div>
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
                <div data-id="7" data-name="MetaQuest3-1TB" data-price="479.99" class="description">Meta Quest 3 1TB
                </div>
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
                <div class="description" data-id="47" data-name="MarvelSpiderman2" data-price="49.99">Marvel SpiderMan 2
                </div>
                <div class="description">Was £69.99</div>
                <div class="description">Now £49.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        class Slideshow {
            constructor() {
                this.slideIndex = 0;
                this.slides = document.getElementsByClassName("mySlides");
                this.dots = document.getElementsByClassName("dot");
                this.interval = null;
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
                this.interval = setInterval(() => {
                    this.changeSlide(1);
                }, this.intervalDuration);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            new Slideshow();
        });

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
                const Data_Wishlist = { id: id };
                const resp = await fetch('/addToWishlist.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(Data_Wishlist)
                });
                const data = await resp.json();
                if (data.status === "success") {
                    alert("Item has been added to wishlist");
                } else {
                    alert(data.message || "Error adding item to wishlist");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("Error adding item to wishlist: " + error.message);
            }
        }

    </script>
    <!-- Include Footer -->
    <?php include 'footer.php'; ?>