<?php
require_once 'dbconnection.php';
include 'header.php';
?>

<h1>Shop by Brand</h1>
<div class="section-container">
    <div class="gallery">
        <a href="ps5.php">
            <img src="images/playstation-blue.svg" alt="PLAYSTATION">
            <div class="description">PLAYSTATION</div>
        </a>
    </div>
    <div class="gallery">
        <a href="xbox.php">
            <img src="images/xbox.svg" alt="XBOX">
            <div class="description">XBOX</div>
        </a>
    </div>
    <div class="gallery">
        <a href="nintendo.php">
            <img src="images/nintendo.svg" alt="NINTENDO">
            <div class="description">NINTENDO</div>
        </a>
    </div>
    <div class="gallery">
        <a href="VR.php">
            <img src="images/meta.svg" alt="META QUEST">
            <div class="description">META QUEST</div>
        </a>
    </div>
    <div class="gallery">
        <a href="pc.php">
            <img src="images/pc.svg" alt="PC">
            <div class="description">PC</div>
        </a>
    </div>
</div>

<h1>GAMES</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=64">
            <img src="images/FC25 XBOX.avif" alt="EA Sports FC 25">
            <div data-id="64" data-name="EA_Sports_FC25" data-price="60.00" class="description">EA Sports FC 25</div>
            <div class="description">£60.00</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=65">
            <img src="images/MINECRAFT XBOX.avif" alt="MINECRAFT">
            <div data-id="65" data-name="MINECRAFT" data-price="19.99" class="description">MINECRAFT</div>
            <div class="description">£19.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=66">
            <img src="images/FARMSIMU XBOX.avif" alt="Farming Simulator 25">
            <div data-id="66" data-name="Farming_Simulator_25" data-price="52.99" class="description">Farming
                Simulator 25</div>
            <div class="description">£52.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=67">
            <img src="images/STARWARS XBOX.avif" alt="Star Wars - Outlaws">
            <div data-id="67" data-name="Star_Wars_Outlaws" data-price="34.99" class="description">Star Wars - Outlaws
            </div>
            <div class="description">£34.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=68">
            <img src="images/UFC25 XBOX.avif" alt="EA Sports UFC 5">
            <div data-id="68" data-name="EA_Sports_UFC5" data-price="59.99" class="description">EA Sports UFC 5</div>
            <div class="description">£59.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=69">
            <img src="images/WWE2K24 XBOX.jpg" alt="WWE 2K24">
            <div data-id="69" data-name="WWE2K24" data-price="20.00" class="description">WWE 2K24</div>
            <div class="description">£20.00</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>

<h1>CONSOLE</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=61">
            <img src="images/XBOXCONSOLE1.avif" alt="Xbox Series X">
            <div data-id="61" data-name="Xbox_Series_X" data-price="459.99" class="description">Microsoft Xbox Series
                X</div>
            <div class="description">£459.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=62">
            <img src="images/XBOXCONSOLE2.avif" alt="Xbox Series S">
            <div data-id="62" data-name="Xbox_Series_S_512GB" data-price="209.99" class="description">Microsoft Xbox
                Series S 512GB</div>
            <div class="description">£209.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=63">
            <img src="images/XBOXCONSOLE3.avif" alt="Xbox Series S 1TB">
            <div data-id="63" data-name="Xbox_Series_S_1TB" data-price="299.99" class="description">Microsoft Xbox
                Series S 1TB Robot White</div>
            <div class="description">£299.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>

<h1>CONTROLLERS & HEADSETS</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=70">
            <img src="images/XBOXHS1.avif" alt="LucidSound Headset">
            <div data-id="70" data-name="LucidSound_LS10X" data-price="19.99" class="description">LucidSound LS10X
                Wired Gaming Headset with Mic for Xbox</div>
            <div class="description">Was £19.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=71">
            <img src="images/XBOXHS2.avif" alt="Turtle Beach Headset">
            <div data-id="71" data-name="TurtleBeach_Stealth500" data-price="89.99" class="description">Turtle Beach
                Stealth 500 Headset for Xbox - Black</div>
            <div class="description">Was £89.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=72">
            <img src="images/XBOXHS3.avif" alt="Turtle Beach Recon 70">
            <div data-id="72" data-name="TurtleBeach_Recon70" data-price="24.99" class="description">Turtle Beach
                Recon 70 Multi-Platform Black Headset</div>
            <div class="description">£24.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=73">
            <img src="images/XBOXBLACK.avif" alt="Xbox Controller Black">
            <div data-id="73" data-name="Xbox_Controller_Black" data-price="49.99" class="description">Xbox Series X
                & S Controller – Carbon Black</div>
            <div class="description">£49.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=74">
            <img src="images/XBOXGREEN.avif" alt="Xbox Controller Green">
            <div data-id="74" data-name="Xbox_Controller_Green" data-price="49.99" class="description">Xbox Wireless
                Controller - Velocity Green</div>
            <div class="description">£49.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=75">
            <img src="images/XBOXWHITE.avif" alt="Xbox Controller White">
            <div data-id="75" data-name="Xbox_Controller_White" data-price="49.99" class="description">Xbox Series X
                & S Controller – Robot White</div>
            <div class="description">Was £49.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>

<h1>DIGITAL</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=76">
            <img src="images/12GP.avif" alt="12 Month Game Pass">
            <div data-id="76" data-name="GamePass_12Month" data-price="49.99" class="description">Xbox Game Pass Core
                - 12 Month Membership</div>
            <div class="description">£49.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=77">
            <img src="images/3GP.avif" alt="3 Month Game Pass">
            <div data-id="77" data-name="GamePass_3Month" data-price="19.99" class="description">Xbox Game Pass Core -
                3 Month Membership</div>
            <div class="description">Was £19.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=78">
            <img src="images/50GC.webp" alt="£50 Gift Card">
            <div data-id="78" data-name="GiftCard_50" data-price="50.00" class="description">£50 Xbox Gift Card -
                Digital Code</div>
            <div class="description">£50.00</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=79">
            <img src="images/10GC.webp" alt="£10 Gift Card">
            <div data-id="79" data-name="GiftCard_10" data-price="10.00" class="description">£10 Xbox Gift Card -
                Digital Code</div>
            <div class="description">£10.00</div>
        </a>
        <div class="buttons">
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=80">
            <img src="images/20GF.avif" alt="£20 Gift Card">
            <div data-id="80" data-name="GiftCard_20" data-price="20.00" class="description">£20 Xbox Gift Card -
                Digital Code</div>
            <div class="description">£20.00</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=81">
            <img src="images/15GC.webp" alt="£15 Gift Card">
            <div data-id="81" data-name="GiftCard_15" data-price="15.00" class="description">£15 Xbox Gift Card -
                Digital Code</div>
            <div class="description">Was £15.00</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
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
</html>