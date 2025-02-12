<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - GamePoint</title>
  <link rel="stylesheet" href="ps5styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
  <style>
    .container {
      max-width: 500px;
      margin: 20px auto;
      padding: 20px;
      background-color: #f4f4f4;
      border-radius: 8px;
    }

    .container label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }

    .container input,
    .container textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .container button {
      display: block;
      width: 150px;
      margin: 10px auto 0;
      padding: 10px 20px;
      background-color: white;
      color: black;
      font-size: 16px;
      font-weight: bold;
      border: 2px solid black;
      border-radius: 5px;
      cursor: pointer;
      text-align: center;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .container button:hover {
      background-color: black;
      color: white;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="grad3">
    <img src="images/GamePointLogo.png" class="logo" alt="GamePoint Logo">
    <h2>GamePoint</h2>
  </div>

  <!-- Navbar -->
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
    
<!-- Main Content -->
<h1>Contact Us</h1>
<div class="container">
    <form
            action="https://formspree.io/f/meoqware"
            method="POST"
    >
        <label>
            Your email:
            <input type="email" name="email">
        </label>
        <label>
            Your message:
            <textarea name="message"></textarea>
        </label>
        <button type="submit">Send</button>
    </form>
</div>



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
                  <li><a href="aboutus.html">About Us</a></li>
                  <li><a href="experts.html">Experts and Spokemodels</a></li>
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
          <a href="sb.html" class="back-to-top-button">BACK TO TOP ↑</a>
      </div>
  </footer>