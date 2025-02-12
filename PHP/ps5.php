<?php
require_once 'dbconnection.php';

include 'header.php';
?>
<div class="video-container">
    <video autoplay muted loop>
        <source src="images/ps5video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<h1>FEATURED PS5 CONSOLES & BUNDLES</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=41">
            <img src="images/ps5-slim.jpg" alt="PS5 Slim Console">
        </a>
        <div data-id="41" data-name="PlayStation5Slim_DiscVersion" data-price="479.99" class="description">PlayStation
            5 Slim (Disc Version)</div>
        <div class="description">£479.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=42">
            <img src="images/digitaledition-ps5.jpg" alt="PS5 Digital Edition">
        </a>
        <div data-id="42" data-name="PlayStation5_DigitalEdition" data-price="389.99" class="description">PlayStation
            5 Digital Edition</div>
        <div class="description">£389.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=43">
            <img src="images/fortniteps5bundle.jpg" alt="PS5 Fortnite Bundle">
        </a>
        <div data-id="43" data-name="PS5_FortniteBundle" data-price="499.99" class="description">PS5 Fortnite Bundle
        </div>
        <div class="description">£499.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=44">
            <img src="images/Callofdutyps5bundle.jpg" alt="PS5 Call of Duty Bundle">
        </a>
        <div data-id="44" data-name="PS5_CODBundle" data-price="499.99" class="description">PS5 Call of Duty: Modern
            Warfare II Bundle</div>
        <div class="description">£499.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=45">
            <img src="images/spidermanps5bundle.jpg" alt="PS5 Spider-Man 2 Bundle">
        </a>
        <div data-id="45" data-name="PS5_Spider-man2Bundle" data-price="499.99" class="description">PS5 Marvels
            Spider-Man 2 Bundle</div>
        <div class="description">£499.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>

<h1>LATEST PS5 GAMES</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=46">
            <img src="images/fc25.jpg" alt="FC 25">
        </a>
        <div data-id="46" data-name="FC25" data-price="69.99" class="description">EA Sports FC 25</div>
        <div class="description">£69.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=47">
            <img src="images/spiderman2ps5.jpg" alt="Spider-Man 2">
        </a>
        <div data-id="47" data-name="MarvelSpiderman2" data-price="59.99" class="description">Marvels Spider-Man 2
        </div>
        <div class="description">£59.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=48">
            <img src="images/mw3ps5.jpg" alt="Call of Duty MW3">
        </a>
        <div data-id="48" data-name="COD_MW3" data-price="64.99" class="description">Call of Duty: Modern Warfare III
        </div>
        <div class="description">£64.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=49">
            <img src="images/Nba2k24ps5.jpg" alt="NBA 2K24">
        </a>
        <div data-id="49" data-name="NBA2K24" data-price="54.99" class="description">NBA 2K24</div>
        <div class="description">£54.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=50">
            <img src="images/hogwartslegacyps5.jpg" alt="Hogwarts Legacy">
        </a>
        <div data-id="50" data-name="HogwartsLegacy" data-price="49.99" class="description">Hogwarts Legacy</div>
        <div class="description">£49.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>

<h1>PS5 ACCESSORIES</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=51">
            <img src="images/ps5-controller.jpg" alt="DualSense Controller">
        </a>
        <div data-id="51" data-name="DualsenseController" data-price="59.99" class="description">DualSense Wireless
            Controller</div>
        <div class="description">£59.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=52">
            <img src="images/ps5-headphones.jpg" alt="PS5 Pulse 3D Headset">
        </a>
        <div data-id="52" data-name="Pulse3DHeadset" data-price="89.99" class="description">PULSE 3D Wireless Headset
        </div>
        <div class="description">£89.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=53">
            <img src="images/chargingstationps5.jpg" alt="DualSense Charging Station">
        </a>
        <div data-id="53" data-name="DualsenseChargingStation" data-price="34.99" class="description">DualSense
            Charging Station</div>
        <div class="description">£34.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=54">
            <img src="images/ps5portal.jpg" alt="PS5 Portable">
        </a>
        <div data-id="54" data-name="PS5_Portable" data-price="249.99" class="description">PS5 Portable</div>
        <div class="description">£249.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=55">
            <img src="images/ps5camera.jpg" alt="PS5 HD Camera">
        </a>
        <div data-id="55" data-name="PS5_HDCamera" data-price="49.99" class="description">PS5 HD Camera</div>
        <div class="description">£49.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>

<h1>PS5 MEMBERSHIPS & GIFT CARDS</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=56">
            <img src="images/psplus-essential.jpg" alt="PS Plus Essential">
        </a>
        <div data-id="56" data-name="PSPlusEssential" data-price="59.99" class="description">PlayStation Plus
            Essential - 12 Months</div>
        <div class="description">£59.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=57">
            <img src="images/ps5plus-extra.png" alt="PS Plus Extra">
        </a>
        <div data-id="57" data-name="PSPlusExtra" data-price="99.99" class="description">PlayStation Plus Extra - 12
            Months</div>
        <div class="description">£99.99</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=58">
            <img src="images/20GBPps5.jpg" alt="£20 PSN Card">
        </a>
        <div data-id="58" data-name="20PSNCard" data-price="20" class="description">PlayStation Store Gift Card - £20
        </div>
        <div class="description">£20.00</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=59">
            <img src="images/50GBPps5.jpg" alt="£50 PSN Card">
        </a>
        <div data-id="59" data-name="50PSNCard" data-price="50" class="description">PlayStation Store Gift Card - £50
        </div>
        <div class="description">£50.00</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>

    <div class="gallery">
        <a href="product.php?id=60">
            <img src="images/100GBPps5.jpg" alt="£100 PSN Card">
        </a>
        <div data-id="60" data-name="100PSNCard" data-price="100" class="description">PlayStation Store Gift Card -
            £100</div>
        <div class="description">£100.00</div>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>

<script>
    async function addToBasket(button) {
        const gallery = button.closest('.gallery');
        const description = gallery.querySelector('.description[data-id]');
        const id = description.getAttribute('data-id');
        const name = description.getAttribute('data-name');
        const price = description.getAttribute('data-price');
        const Data_Basket = { id: id, name: name, price: price };
        try {
            const resp = fetch('addToBasket.php', { method: 'POST', headers: { 'Content-Type': 'application/json', }, body: JSON.stringify(Data_Basket) });
            const data = await resp.json();
            if (data.status === "success") {
                alert("Item has been added to basket");
            } else {
                alert("error : " + data.message);
            }
        } catch (error) {
            console.error("error : " + error);
        }
    }
    async function addToWishlist(button) {
        const gallery = button.closest('.gallery');
        const description = gallery.querySelector('.description[data-id]');
        const id = description.getAttribute('data-id');
        const name = description.getAttribute('data-name');
        const price = description.getAttribute('data-price');

        const Data_Wishlist = { id: id, name: name, price: price };

        try {
            const resp = fetch('addToWishlist.php', { method: 'POST', headers: { 'Content-Type': 'application/json', }, body: JSON.stringify(Data_wishlist) });
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

<?php include 'footer.php';?>
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