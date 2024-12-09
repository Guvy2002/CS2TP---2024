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

    <h1>FEATURED VR HEADSETS & BUNDLES</h1>
    <div class="section-container">
        <div class="gallery">
            <a href="product.php?id=115">
                <img src="images/psvr2.jpg" alt="PlayStation VR 2">
            </a>
            <div data-id="115" class="description">PlayStation VR 2</div>
            <div class="description">£529.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=82">
                <img src="images/quest3.jpg" alt="Meta Quest 3">
            </a>
            <div data-id="82" class="description">Meta Quest 3 (128GB)</div>
            <div class="description">£529.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=83">
                <img src="images/vive.jpg" alt="HTC Vive Pro 2">
            </a>
            <div data-id="83" class="description">HTC Vive Pro 2</div>
            <div class="description">£719.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=84">
                <img src="images/quest2.jpg" alt="Meta Quest 2">
            </a>
            <div data-id="84" class="description">Meta Quest 2 (128GB)</div>
            <div class="description">£489.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

    </div>

    <h1>POPULAR VR GAMES</h1>
    <div class="section-container">

        <div class="gallery">
            <a href="product.php?id=85">
                <img src="images/beat-saber.jpg" alt="Beat Saber">
            </a>
            <div data-id="85" class="description">Beat Saber</div>
            <div class="description">£29.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=86">
                <img src="images/arizona.jpg" alt="Arizona Sunshine 2">
            </a>
            <div data-id="86" class="description">Arizona Sunshine 2</div>
            <div class="description">£49.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=87">
                <img src="images/among-us-vr.png" alt="Among Us VR">
            </a>
            <div data-id="87" class="description">Among Us VR</div>
            <div class="description">£14.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=88">
                <img src="images/resident-evil-4.jpg" alt="Resident Evil 4 VR">
            </a>
            <div data-id="88" class="description">Resident Evil 4 VR</div>
            <div class="description">£39.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>
    </div>

    <h1>VR ACCESSORIES</h1>
    <div class="section-container">

        <div class="gallery">
            <a href="product.php?id=89">
                <img src="images/vr-facial-interface.png" alt="VR Facial Interface">
            </a>
            <div data-id="89" class="description">Premium VR Facial Interface</div>
            <div class="description">£29.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=90">
                <img src="images/vr-headstrap.jpg" alt="Elite Head Strap">
            </a>
            <div data-id="90" class="description">Elite Head Strap with Battery</div>
            <div class="description">£89.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=91">
                <img src="images/vr-case.jpg" alt="VR Carrying Case">
            </a>
            <div data-id="91" class="description">Premium VR Carrying Case</div>
            <div class="description">£49.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>

        <div class="gallery">
            <a href="product.php?id=92">
                <img src="images/vr-powerbank.jpeg" alt="VR Power Bank">
            </a>
            <div data-id="92" class="description">10000mAh VR Power Bank</div>
            <div class="description">£69.99</div>
        	<div class="buttons">
            	<button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            	<button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        	</div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
<script>
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