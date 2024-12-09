<?php
require_once 'dbconnection.php';
include 'header.php';
?>

<body>
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
            <a href="product.php?id=1">
                <img src="images/NITENDO GAME 1.avif" alt="Just Dance 2025">
                <div data-id="1" data-name="JustDance2025" data-price="30.00" class="description">Just Dance 2025
                </div>
                <div class="description">£30.00</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=2">
                <img src="images/NITENDO GAME 3.avif" alt="Minecraft">
                <div data-id="2" data-name="MinecraftSwitch" data-price="22.99" class="description">Minecraft for
                    Nintendo Switch</div>
                <div class="description">£22.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=3">
                <img src="images/NITENDO GAME 4.avif" alt="Super Mario">
                <div data-id="3" data-name="SuperMarioBros" data-price="44.99" class="description">Super Mario Bros.
                    Wonder</div>
                <div class="description">£44.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=4">
                <img src="images/NITENDO GAME 5.avif" alt="EA Sports">
                <div data-id="4" data-name="EAFC25" data-price="40.00" class="description">EA Sports FC 25</div>
                <div class="description">£40.00</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=5">
                <img src="images/NITENDO GAME 6.avif" alt="Crash Bandicoot">
                <div data-id="5" data-name="CrashBandicoot" data-price="20.00" class="description">Crash Bandicoot N.
                    Sane Trilogy</div>
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
            <a href="product.php?id=6">
                <img src="images/NC1.jpg" alt="OLED Bundle">
                <div data-id="6" data-name="SwitchOLEDMario" data-price="299.99" class="description">Nintendo Switch
                    (OLED model) + Mario Wonder + 12 Months NSO</div>
                <div class="description">£299.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=7">
                <img src="images/NC2.jpg" alt="Switch Neon">
                <div data-id="7" data-name="SwitchNeon" data-price="249.99" class="description">Nintendo Switch - Neon
                    (Improved Battery)</div>
                <div class="description">£249.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=8">
                <img src="images/NC4.jpg" alt="Switch Sports Bundle">
                <div data-id="8" data-name="SwitchSportsBundle" data-price="249.99" class="description">Nintendo
                    Switch (Neon Red/Neon Blue) Switch Sports + 12 Months NSO</div>
                <div class="description">£249.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=9">
                <img src="images/NC3.jpg" alt="OLED White">
                <div data-id="9" data-name="SwitchOLEDWhite" data-price="309.99" class="description">Nintendo Switch -
                    White (OLED Model)</div>
                <div class="description">£309.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=10">
                <img src="images/NC5.jpg" alt="Switch Lite">
                <div data-id="10" data-name="SwitchLite" data-price="199.99" class="description">Nintendo Switch Lite -
                    Turquoise</div>
                <div class="description">£199.99</div>
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
            <a href="product.php?id=11">
                <img src="images/NSC1.avif" alt="Joy-Con">
                <div data-id="11" data-name="JoyConBlueYellow" data-price="69.99" class="description">Nintendo Switch
                    Joy-Con Pair: Blue/Yellow</div>
                <div class="description">Was £69.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=12">
                <img src="images/NSC2.avif" alt="Racing Wheels">
                <div data-id="12" data-name="RacingWheels" data-price="11.99" class="description">Subsonic Red and
                    Blue Duo Racing Wheels For Switch</div>
                <div class="description">Was £11.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=13">
                <img src="images/NSC3.avif" alt="Joy-Con Grips">
                <div data-id="13" data-name="JoyConGrips" data-price="8.99" class="description">Numskull Joy Con Grips
                    for Switch</div>
                <div class="description">£8.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=14">
                <img src="images/NSC4.avif" alt="Afterglow Controller">
                <div data-id="14" data-name="AfterglowController" data-price="45.99" class="description">Afterglow
                    Wave Wireless Controller White</div>
                <div class="description">£45.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=15">
                <img src="images/NSC5.avif" alt="Prismatic Controller">
                <div data-id="15" data-name="PrismaticController" data-price="30.99" class="description">Prismatic
                    Switch Wireless Controller</div>
                <div class="description">£30.99</div>
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
            <a href="product.php?id=16">
                <img src="images/NS12M.jpg" alt="NSO 12 Month">
                <div data-id="16" data-name="NSO12Month" data-price="19.99" class="description">Nintendo Switch Online
                    12 Month Membership</div>
                <div class="description">£19.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=17">
                <img src="images/NS12EXPANSION.jpg" alt="NSO Expansion">
                <div data-id="17" data-name="NSOExpansion" data-price="34.99" class="description">Nintendo NSO +
                    Expansion Pack 12 Month Membership</div>
                <div class="description">£34.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=18">
                <img src="images/NS2M.jpg" alt="NSO 3 Month">
                <div data-id="18" data-name="NSO3Month" data-price="6.99" class="description">Nintendo Switch Online 3
                    Month (90 Day) Membership</div>
                <div class="description">£6.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=19">
                <img src="images/NSMARIOPASS.jpg" alt="Mario Kart Pass">
                <div data-id="19" data-name="MarioKartPass" data-price="24.99" class="description">Mario Kart 8 Deluxe
                    Booster Course Pass</div>
                <div class="description">£24.99</div>
            </a>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>

        <div class="gallery">
            <a href="product.php?id=20">
                <img src="images/NSPPASS.jpg" alt="Pokemon Pass">
                <div data-id="20" data-name="PokemonPass" data-price="35.00" class="description">Pokémon Scarlet or
                    Violet Expansion Pass</div>
                <div class="description">£35.00</div>
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
            setTimeout(showSlides, 2000);
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