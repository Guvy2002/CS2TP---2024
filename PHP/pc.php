<?php
require_once 'dbconnection.php';
include 'header.php';
?>

<h1>Shop by Brand </h1>

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

<h1>HEADSETS</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=21">
            <img src="images/HEADSET 1.avif" alt="Turtle Beach Recon 50">
            <div data-id="21" data-name="TurtleBeach_Recon50" data-price="15.99" class="description">
                Turtle Beach Recon 50 Headset – Black
            </div>
            <div class="description">£15.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=22">
            <img src="images/HEADSET 2.avif" alt="Razer Kraken V3">
            <div data-id="22" data-name="Razer_KrakenV3" data-price="69.99" class="description">
                Razer Kraken V3 X USB Wired Gaming Headset
            </div>
            <div class="description">£69.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=23">
            <img src="images/HEADSET 3.avif" alt="Turtle Beach Recon 70">
            <div data-id="23" data-name="TurtleBeach_Recon70" data-price="29.99" class="description">
                Turtle Beach Recon 70 Headset for PC
            </div>
            <div class="description">£29.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=24">
            <img src="images/HEADSET 6.avif" alt="Razer Fortnite Headset">
            <div data-id="24" data-name="Razer_FortniteHeadset" data-price="39.99" class="description">
                Razer - Fortnite Wired PC Gaming Headset
            </div>
            <div class="description">£39.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=25">
            <img src="images/HEADSET 4.avif" alt="JBL Quantum">
            <div data-id="25" data-name="JBL_QuantumHeadset" data-price="149.99" class="description">
                JBL Quantum Gaming Headset for PC
            </div>
            <div class="description">£149.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>
<h1>KEYBOARDS AND MICE</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=26">
            <img src="images/KB1.avif" alt="Trust Mechanical Keyboard">
            <div data-id="26" data-name="Trust_GXT865" data-price="69.99" class="description">
                Trust GXT 865 Asta Mechanical Keyboard
            </div>
            <div class="description">£69.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=27">
            <img src="images/KB3.avif" alt="Trust TKL Keyboard">
            <div data-id="27" data-name="Trust_GXT833W" data-price="22.99" class="description">
                Trust GXT 833W Thado TKL Keyboard - White
            </div>
            <div class="description">£22.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=28">
            <img src="images/M1.avif" alt="Razer Mouse">
            <div data-id="28" data-name="Razer_DeathAdder" data-price="24.99" class="description">
                Razer DeathAdder Essential Mouse - Black
            </div>
            <div class="description">£24.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=29">
            <img src="images/M2.avif" alt="Trust Mouse">
            <div data-id="29" data-name="Trust_GXT109B" data-price="9.99" class="description">
                Trust GXT 109B Felox Gaming Mouse
            </div>
            <div class="description">£9.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=30">
            <img src="images/M3.avif" alt="Logitech Mouse">
            <div data-id="30" data-name="Logitech_G203" data-price="23.00" class="description">
                Logitech G203 Lightsync Gaming Mouse
            </div>
            <div class="description">£23.00</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>
<h1>MICROPHONES</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=31">
            <img src="images/MIC1.jpg" alt="HyperX Microphone">
            <div data-id="31" data-name="HyperX_Quadcast" data-price="89.99" class="description">
                HyperX Quadcast Microphone
            </div>
            <div class="description">£89.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=32">
            <img src="images/MIC2.avif" alt="Razer Microphone">
            <div data-id="32" data-name="Razer_SeirenV3" data-price="189.99" class="description">
                Razer Seiren V3 Chroma Microphone
            </div>
            <div class="description">£189.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=33">
            <img src="images/MIC3.avif" alt="Numskull Microphone">
            <div data-id="33" data-name="Numskull_LED" data-price="24.99" class="description">
                Numskull LED Microphone
            </div>
            <div class="description">£24.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=34">
            <img src="images/MIC4.avif" alt="Trust Microphone">
            <div data-id="34" data-name="Trust_GXT234" data-price="29.99" class="description">
                TRUST GXT234 YUNIX USB MIC
            </div>
            <div class="description">£29.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=35">
            <img src="images/MIC6.avif" alt="Seiren Mini">
            <div data-id="35" data-name="Seiren_V3Mini" data-price="59.99" class="description">
                Seiren V3 Mini Microphone - White
            </div>
            <div class="description">£59.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
</div>
<h1>MONITORS</h1>
<div class="section-container">
    <div class="gallery">
        <a href="product.php?id=36">
            <img src="images/Monitor1.avif" alt="MSI Monitor">
            <div data-id="36" data-name="MSI_G27CQ4" data-price="218.99" class="description">
                MSI G27CQ4 E2 Gaming Monitor
            </div>
            <div class="description">£218.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=37">
            <img src="images/Monitor2.avif" alt="ASUS Monitor">
            <div data-id="37" data-name="ASUS_VG249QL3A" data-price="199.99" class="description">
                ASUS TUF Gaming VG249QL3A Monitor
            </div>
            <div class="description">£199.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=38">
            <img src="images/Monitor3.avif" alt="ASUS 4K Monitor">
            <div data-id="38" data-name="ASUS_CG32UQ" data-price="449.99" class="description">
                ASUS CG32UQ HDR Console Gaming Monitor – 32inch 4K
            </div>
            <div class="description">£449.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=39">
            <img src="images/Monitor4.avif" alt="LG Monitor">
            <div data-id="39" data-name="LG_27UG" data-price="279.99" class="description">
                LG PC KB LG 27 UG QHD MNTR 165hz
            </div>
            <div class="description">£279.99</div>
        </a>
        <div class="buttons">
            <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
            <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
        </div>
    </div>
    <div class="gallery">
        <a href="product.php?id=40">
            <img src="images/Monitor5.avif" alt="MSI Monitor">
            <div data-id="40" data-name="MSI_G255F" data-price="149.99" class="description">
                MSI G255F Gaming Monitor
            </div>
            <div class="description">£149.99</div>
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