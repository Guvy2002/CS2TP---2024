<?php

require_once('DBconnection.php');

if(isset($_POST['submit'])){
    $customerID = $_COOKIE["customerID"];
    $fullName = $_POST['full-name'];
    $contactNumber = $_POST['number'];
    $address = $_POST['address'];
    $address2 = $_POST['address2'];
    $totalAddress = $address . " " . $address2;
    $city = $_POST['city'];
    $postcode = $_POST['postal-code'];
    $country = $_POST['country'];
    $cardName = $_POST['card-name'];
    $cardAddress  = $_POST['card-address'];
    $cardAddress2  = $_POST['card-address2'];
    $totalCardAddress = $cardAddress . " " . $cardAddress2;
    $cardNumber = $_POST['card-number'];
    $expiryMonth = $_POST['expiry'];
    $cvv = $_POST['cvv'];
    $quantity = $_COOKIE["quantity"];
    $subtotal = $_COOKIE["subtotal"];
    $date = date("y-m-d");
    $type = 'Card';

    try {
        if ($postcode > 10){
            throw new exception("Postcode is to long");
        }
        if ($cardNumber > 19) {
            throw new exception("Card number is to long");
        }
        if ($cvv > 3){
            throw new exception("CVV/CVC is to long");
        }
        $stmt = $conn->prepare("INSERT INTO Orders (customerID, totalPrice, OrderDate, BillingAddress, ShippingAddress) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss",$customerID, $subtotal, $date, $totalCardAddress, $totalAddress);
        $ordersID = "SELECT orderID, customerID FROM Orders";
        $ordersIDsResult = mysqli_query->query($conn, $ordersID);
        if (mysqli_num_rows($ordersIDsResult) > 0) {
            while ($row = mysqli_fetch_assoc($ordersIDsResult)) {
                if ($row['customerID'] == $customerID) {
                    $orderID = $row['orderID'];
                }
            }
        }
        $stmt = $conn->prepare("INSERT INTO Payment (orderID, paymentDate, Amount, paymentMethod) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss",$orderID, $date, $subtotal, $type);
        $paymentIDs = "SELECT orderID, paymentID FROM Payment";
        $paymentIDsResult = mysqli_query->query($conn, $paymentIDs);
        if (mysqli_num_rows($paymentIDsResult) > 0) {
            while ($row = mysqli_fetch_assoc($paymentIDsResult)) {
                if ($row['orderID'] == $orderID) {
                    $paymentID = $row['paymentID'];
                    $stmt = $conn->prepare("INSERT INTO Orders (paymentID) VALUES (?)");
                    $stmt->bind_param("s",$paymentID);
                }
            }
        }
        mysqli_close($conn);
    }
    catch (Exception $e){
        echo $e->getMessage();
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - GamePoint</title>
  <link rel="stylesheet" href="ps5styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<body>

  <!-- Header -->
  <div class="grad3">
    <img src="Images/GamePointLogo.png" class="logo" alt="GamePoint Logo">
    <h2>GamePoint</h2>
  </div>

  <style>
    .grad3 {
      height: 100px;
      background-color: red;
      background-image: linear-gradient(180deg, rgb(49, 43, 43), rgb(248, 244, 249));
    }

    .checkout-container {
      max-width: 800px;
      margin: auto;
      padding: 20px;
    }

    .section {
      margin-bottom: 20px;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background: #f9f9f9;
    }

    .section h3 {
      margin-bottom: 15px;
    }

    .input-group {
      margin-bottom: 10px;
    }

    .input-group label {
      display: block;
      margin-bottom: 5px;
    }

    .input-group input,
    .input-group select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .order-summary {
      list-style-type: none;
      padding: 0;
    }

    .order-summary li {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: red;
      color: white;
      border: none;
      border-radius: 5px;
      text-align: center;
      cursor: pointer;
      font-size: 16px;
    }

    .btn:hover {
      background-color: darkred;
    }
  </style>

  <!-- Checkout Container -->
  <div class="checkout-container">
    <h1>Checkout</h1>

    <!-- Cart Summary -->
    <div class="section">
      <h3>Order Summary</h3>
      <ul class="order-summary">
        <li>
          <span>PlayStation 5</span>
          <span>£389.99</span>
        </li>
        <li>
          <span>Gran Turismo 7</span>
          <span>£49.99</span>
        </li>
        <li>
          <strong>Total</strong>
          <strong><?php echo $subtotal ?></strong>
        </li>
      </ul>
    </div>

    <!-- Shipping Information -->
    <div class="section">
      <h3>Shipping Information</h3>
      <form>
        <div class="input-group">
          <label for="full-name">Full Name*</label>
          <input type="text" id="full-name" name="full-name" required>
        </div>
        <div class="input-group">
          <label for="number">Contact Number*</label>
          <input type="tel" id="number" name="number" required>
        </div>
        <div class="input-group">
          <label for="address">Address Line 1*</label>
          <input type="text" id="address" name="address" required>
        </div>
        <div class="input-group">
          <label for="address2">Address Line 2</label>
          <input type="text" id="address2" name="address2" required>
        </div>
        <div class="input-group">
          <label for="city">City*</label>
          <input type="text" id="city" name="city" required>
        </div>
        <div class="input-group">
          <label for="postal-code">Postal Code*</label>
          <input type="text" id="postal-code" name="postal-code" required>
        </div>
        <div class="input-group">
          <label for="country">Country*</label>
          <select id="country" name="country" required>
            <option value="uk">United Kingdom</option>
            <option value="us">United States</option>
            <option value="ca">Canada</option>
          </select>
        </div>
      </form>
    </div>

    <!-- Payment Information -->
    <div class="section">
      <h3>Payment Information</h3>
      <form>
        <div class="input-group">
          <label for="card-name">Name on Card*</label>
          <input type="text" id="card-name" name="card-name" required>
        </div>
        <div class="input-group">
          <label for="card-number">Card Number*</label>
          <input type="text" id="card-number" name="card-number" required>
        </div>
        <div class="input-group">
          <label for="card-address">Address Line 1*</label>
          <input type="text" id="card-address" name="card-address" required>
        </div>
        <div class="input-group">
          <label for="card-address2">Address Line 2</label>
          <input type="text" id="card-address2" name="card-address2" required>
        </div>
        <div class="input-group">
          <label for="expiry">Expiry Date*</label>
          <input type="month" id="expiry" name="expiry" required>
        </div>
        <div class="input-group">
          <label for="cvv">CVV/CVC*</label>
          <input type="number" id="cvv" name="cvv" required>
        </div>
      </form>
    </div>

    <!-- Confirm Order Button -->
    <button class="confirm-order-btn">Confirm Order</button>
  </div>

 <!-- FOOTER -->
 <style>
    .footer {
        height: 200px;
        background-color: red;
        /* For browsers that do not support gradients */
        background-image: linear-gradient(180deg, rgb(249, 244, 244), rgb(50, 50, 50));
    }
</style>
<!-- Section: Links -->
<section class="footer">
    <!-- Section: Form -->
    <section class="">
        <form action="">
            <!--Grid row-->
            <div class="row d-flex justify-content-center">
                <!--Grid column-->
                <div class="col-auto">
                    <p class="pt-2">
                        <strong>Sign up to our newsletter by entering your email address</strong>
                    </p>
                </div>
                <div class="col-md-5 col-12">
                    <!-- Email input -->
                    <div class="form-outline form-white mb-4">
                        <input type="email" id="form5Example21" class="form-control" />
                        <label class="form-label" for="form5Example21"> <button type="submit"
                                class="btn btn-outline-light mb-4">
                                Subscribe
                            </button></label>
                    </div>
                    <!--Grid column-->
                </div>
        </form>
    </section>
    <!-- Section: Form -->

    <!-- Section: Text -->
    <div class="mb-4">
        <p>
            Thank you for visiting our website ! Please checkout our products and get the most exclusive and
            trending
            games at the best and most affordable prices !

        </p>


        <!-- Social Media Section -->
        <div class="social-media">
            <h5>Follow Us on Social Media</h5>
            <div class="social-icons">
                <a href="https://www.instagram.com" target="_blank">
                    <i class="bi bi-instagram"></i>
                    <!-- <img src="Images/insta logo.webp" alt="Instagram" class="social-icon"> -->
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <i class="bi bi-twitter-x"></i>
                    <!-- <img src="Images/twitter logo.png" alt="Twitter" class="social-icon"> -->
                </a>
                <a href="https://www.facebook.com" target="_blank">
                    <i class="bi bi-facebook"></i>
                    <!-- <img src="Images/facebook logo.png" alt="Facebook" class="social-icon"> -->
                </a>
                <a href="https://www.tiktok.com" target="_blank">
                    <i class="bi bi-tiktok"></i>
                    <!-- <img src="Images/tiktok logo.webp" alt="TikTok" class="social-icon"> -->
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="copyright" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Copyright:
            <a class="text-white" href="#">GamePoint</a>
        </div>
        <!-- Copyright -->
    </div>
</section>
</body>

</html>