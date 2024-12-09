<?php 
require_once('dbconnection.php');
include 'header.php';
?>

  <style>
   
    .about-container {
      margin: 20px auto;
      max-width: 800px;
      padding: 20px;
      font-family: Arial, sans-serif;
      color: #333;
      background-color: #f8f8f8;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .about-section {
      margin-bottom: 40px;
    }

    .about-container h1,
    .about-container h2 {
      text-align: center;
    }

    .about-container h2 {
      font-size: 28px;
      margin-bottom: 15px;
    }

    .about-container p {
      line-height: 1.8;
      font-size: 18px;
      margin-bottom: 15px;
      text-align: justify;
    }
  </style>

  <div class="about-container">
    <h1 style="text-align: center; margin-bottom: 40px;">About GamePoint</h1>
  
    <div class="about-section">
      <h2 style="text-align: center; margin-bottom: 20px;">Our Story</h2>
      <p>
        GamePoint was founded by a group of like minded individuals with a simple yet powerful vision: to connect gamers with the best in entertainment technology. Since our inception, we have dedicated ourselves to curating a diverse range of products, from consoles like PlayStation and Xbox to cutting-edge VR equipment and gaming accessories.
      </p>
      <p>
        Launched in 2024, GamePoint is passionate about connecting players to the gear and experiences that elevate gaming to the next level.
      </p>
    </div>
  
    <div class="about-section">
      <h2 style="text-align: center; margin-top: 40px; margin-bottom: 20px; padding-left: 25px;">Our Mission</h2>
      <p>
        At GamePoint, our mission is to empower gamers of all skill levels by providing top-notch products and unparalleled service. We aim to create a community where gamers feel inspired and supported, offering not only the tools they need but also fostering connections within the gaming world.
      </p>
      <p>
        The goal isn’t about making a lot of money; it’s about creating something meaningful—a place where visitors can step onto our website and feel a wave of nostalgia, like the joy of a child experiencing their first video game.
      </p>
    </div>
  </div>
  
<?php 
     include 'footer.php'; 
?>
</body>

</html>