<?php
include 'header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Bundles</title>
    <link rel="stylesheet" href="ps5styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
</head>

<body>
    <style>
        .grad3 {
    height: 100px;
            background-color: red;
            background-image: linear-gradient(180deg, rgb(49, 43, 43), rgb(248, 244, 249));
        }
    </style>

    <div class="video-container">
        <video autoplay muted loop>
            <source src="images/specialbundles.mp4" type="video/mp4">
    Your browser does not support the video tag.
        </video>
    </div>

    <h1>MOST PURCHASED BUNDLES</h1>

    <div class="section-container">
        <div class="gallery">
           <a href="product.php?id=93">
            <img src="images/off1.png" alt="PS5SpidermanFree">
        	</a>
    		<div data-id="93" data-name="PS5SpidermanFree" data-price="329.99" class="description">PlayStation5 with spiderman game for FREE!</div>
            <div class="description">£329.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>
        <div class="gallery">
            <a href="product.php?id=94">
            <img src="images/xboxb.png" alt="RazerDuoXBOX">
        	</a>
            <div data-id="94" data-name="RazerDuoXBOX" data-price="89.99" class="description"> Razer Duo Bundle for Xbox</div>
            <div class="description">£89.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>
        <div class="gallery">
            <a href="product.php?id=95">
            <img src="images/off4.png" alt="STARgsmingPCBundle">
        	</a>
            <div data-id="95" data-name="STARgsmingPCBundle" data-price="599.99" class="description">STAR Gaming PC bundle</div>
            <div class="description">£599.99 </div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>
        <div class="gallery">
            <a href="product.php?id=96">
            <img src="images/off2.png" alt="SwitchwMarioFree">
        	</a>
            <div data-id="96" data-name="SwitchwMarioFree" data-price="269.99" class="description">Nintendo Switch with mariokart game for FREE!</div>
            <div class="description">£269.99 </div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>
        <div class="gallery">
            <a href="product.php?id=97">
            <img src="images/off5.png" alt="VRheadset2Controllers">
        	</a>
            <div data-id="97" data-name="VRheadset2Controllers" data-price="459.99" class="description">VR Headset with two controllers</div>
            <div class="description">£459.99</div>
            <div class="buttons">
                <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
            </div>
        </div>
        </div>

        <h1>PLAYSTATION BUNDLES</h1>

        <div class="section-container">
            <div class="gallery">
                <a href="product.php?id=93">
            	<img src="images/off1.png" alt="PS5SpidermanFree">
        		</a>
    			<div data-id="93" data-name="PS5SpidermanFree" data-price="329.99" class="description">PlayStation5 with spiderman game for FREE!</div>
                <div class="description">£329.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=98">
            	<img src="images/ps5a.png" alt="PS5w2Controllers">
        		</a>
                <div data-id="98" data-name="PS5w2Controllers" data-price="299.99" class="description">Playstation 5 with two controllers</div>
                <div class="description">£299.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a target="_blank" href="images/ps5d.png">
                    <img src="images/ps5d.png" alt="Playstation 5 controller with charging station"></a>
                <div data-id="PS5wCS" data-name="PS5wChargingStation" data-price="69.99" class="description">Playstation 5 controller with charging station</div>
                <div class="description">£69.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=99">
            	<img src="images/ps5b.png" alt="PS5wPSPortal">
        		</a>
                <div data-id="99" data-name="PS5wPSPortal" data-price="449.99" class="description">Playstation 5 with Playstation Portal</div>
                <div class="description">£449.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=100">
            	<img src="images/ps5c.png" alt="PS5wPSPulseHeadset">
        		</a>
                <div data-id="100" data-name="PS5wPSPulseHeadset" data-price="349.99" class="description">Playstation 5 with Playstation (PULSE) Headset</div>
                <div class="description">£349.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
        </div>

        <h1>XBOX BUNDLES</h1>

        <div class="section-container">
            <div class="gallery">
                <a href="product.php?id=101">
            	<img src="images/xboxa.png" alt="XBOXseriesXwFC24">
        		</a>
                <div data-id="101" data-name="XBOXseriesXwFC24" data-price="499.99" class="description">Xbox Series X with FC 24 game</div>
                <div class="description">£499.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=94">
            	<img src="images/xboxb.png" alt="RazerDuoXBOX">
        		</a>
            	<div data-id="94" data-name="RazerDuoXBOX" data-price="89.99" class="description"> Razer Duo Bundle for Xbox</div>
                <div class="description">£89.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=102">
            	<img src="images/xboxc.png" alt="XOBXseriesX24month">
        		</a>
                <div data-id="102" data-name="XOBXseriesX24month" data-price="499.99" class="description">Xbox Series X with 24 months Ultimate Gamepass</div>
                <div class="description">£499.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=103">
            	<img src="images/xboxd.png" alt="XBOXseriesXwCloudXHeadset">
        		</a>
                <div data-id="103" data-name="XBOXseriesXwCloudXHeadset" data-price="359.99" class="description">Xbox Series X with CloudX headset</div>
                <div class="description">£359.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=104">
            	<img src="images/xboxe.png" alt="XBOXseriesXw2Controllers">
        		</a>
                <div data-id="104" data-name="XBOXseriesXw2Controllers" data-price="529.99" class="description">Xbox Series X with two controllers</div>
                <div class="description">£529.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
        </div>

        <h1>NINTENDO BUNDLES</h1>

        <div class="section-container">
            <div class="gallery">
                <a href="product.php?id=105">
            	<img src="images/nina.png" alt="SwitchLiteAnimalCrossing">
        		</a>
                <div data-id="105" data-name="SwitchLiteAnimalCrossing" data-price="199.99" class="description">Nintendo Switch Lite with Animal Crossing game</div>
                <div class="description">£199.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=106">
            	<img src="images/ninb.png" alt="VRheadset2Controllers">
        		</a>
                <div data-id="106" data-name="VRheadset2Controllers" data-price="459.99" class="description">Nintendo Switch Lite with extra controller</div>
                <div class="description">£289.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=96">
            	<img src="images/off2.png" alt="SwitchwMarioFree">
        		</a>
                <div data-id="96" data-name="SwitchwMarioFree" data-price="269.99" class="description">Nintendo Switch with mariokart game for FREE!</div>
                <div class="description">£269.99 </div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=107">
            	<img src="images/ninc.png" alt="SwitchwMarioBros1year">
        		</a>
                <div data-id="107" data-name="SwitchwMarioBros1year" data-price="149.99" class="description">Nintendo Switch OLED with Super Mario Bros + Switch Online 1 Year</div>
                <div class="description">£149.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=108">
            	<img src="images/nind.png" alt="SwitchwMarioBrosRacingWheels">
        		</a>
                <div data-id="108" data-name="SwitchwMarioBrosRacingWheels" data-price="299.99" class="description">Nintendo Switch OLED with Mario Kart + Racing Wheels</div>
                <div class="description">£299.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
        </div>

        <h1>PC BUNDLES</h1>

        <div class="section-container">
            <div class="gallery">
                <a href="product.php?id=109">
            	<img src="images/pca.png" alt="KeyboardMouse">
        		</a>
                <div data-id="109" data-name="KeyboardMouse" data-price="49.99" class="description">Wireless Gaming Keyboard Mouse bundle</div>
                <div class="description">£49.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=110">
            	<img src="images/pcb.png" alt="HyperXBundle">
        		</a>
                <div data-id="110" data-name="HyperXBundle" data-price="149.99" class="description">HyperX Bundle</div>
                <div class="description">£129.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=111">
            	<img src="images/pcc.png" alt="StormForceOnyxR51TB">
        		</a>
                <div data-id="111" data-name="StormForceOnyxR51TB" data-price="649.99" class="description">Stormforce Onyx R5 16GB 1TB Gaming PC Bundle</div>
                <div class="description">£649.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=95">
            	<img src="images/off4.png" alt="STARgsmingPCBundle">
        		</a>
                <div data-id="95" data-name="STARgsmingPCBundle" data-price="599.99" class="description">STAR Gaming PC bundle</div>
                <div class="description">£599.99 </div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=112">
            	<img src="images/pcd.png" alt="ViboxII12PC">
        		</a>
                <div data-id="112" data-name="ViboxII12PC" data-price="729.99" class="description">Vibox II-12 Gaming PC Bundle</div>
                <div class="description">£729.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
        </div>

        <h1>VR BUNDLES</h1>

        <div class="section-container">
            <div class="gallery">
                <a href="product.php?id=113">
            	<img src="images/vra.png" alt="MetaQuest2ResidentEvil4">
        		</a>
                <div data-id="113" data-name="MetaQuest2ResidentEvil4" data-price="499.99" class="description">Meta Quest 2 256GB Resident Evil 4 Bundle</div>
                <div class="description">£499.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=114">
            	<img src="images/vrb.png" alt="PSFullVR">
        		</a>
                <div data-id="114" data-name="PSFullVR" data-price="489.99" class="description">Playstation Full VR Bundle</div>
                <div class="description">£489.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=115">
            	<img src="images/psv2.png" alt="SonyPSVRCamera2MontionController">
        		</a>
                <div data-id="115" data-name="SonyPSVRCamera2MontionController" data-price="149.99" class="description">Sony PlayStation VR Bundle with Camera and 2 Motion Controllers</div>
                <div class="description">£149.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=116">
            	<img src="images/vrd.png" alt="AimControllerFarpoint">
        		</a>
                <div data-id="116" data-name="AimControllerFarpoint" data-price="199.99" class="description">Aim Controller Farpoint Bundle</div>
                <div class="description">£199.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
            <div class="gallery">
                <a href="product.php?id=97">
            	<img src="images/off5.png" alt="VRheadset2Controllers">
        		</a>
                <div data-id="97" data-name="VRheadset2Controllers" data-price="459.99" class="description">VR Headset with two controllers</div>
                <div class="description">£459.99</div>
                <div class="buttons">
                    <button onclick="addToBasket(this)" class="btn add-to-basket">Add to Basket</button>
                    <button onclick="addToWishlist(this)" class="btn add-to-wishlist">Add to Wishlist</button>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
async function addToBasket(button) {
    const gallery = button.closest('.gallery');
    const description = gallery.querySelector('.description[data-id]');
    const id = description.getAttribute('data-id');
    const name = description.getAttribute('data-name');
    const price = description.getAttribute('data-price');
    const Data_Basket = {id: id,name: name,price: price};
          try{
              const resp = fetch('addToBasket.php', {method: 'POST',headers: {'Content-Type': 'application/json',},body: JSON.stringify(Data_Basket)});
            const data = await resp.json();
            if (data.status === "success"){
                alert("Item has been added to basket");
            }else{
                alert("error : " + data.message);
            }
          }catch(error){
              console.error("error : " + error);
          }
        }
        async function addToWishlist(button) {
    const gallery = button.closest('.gallery');
    const description = gallery.querySelector('.description[data-id]');
    const id = description.getAttribute('data-id');
    const name = description.getAttribute('data-name');
    const price = description.getAttribute('data-price');

    const Data_Wishlist = {id: id,name: name,price: price};

          try{
              const resp = fetch('addToWishlist.php', {method: 'POST',headers: {'Content-Type': 'application/json',},body: JSON.stringify(Data_wishlist)});
            const data = await resp.json();
            if (data.status === "success"){
                alert("Item has been added to wishlist");
            }else{
                alert("error : " + data.message);
            }
          }catch(error){
              console.error("error : " + error);
          }
        }
    </script>
</body>
</html>
 