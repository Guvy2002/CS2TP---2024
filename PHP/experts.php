<?php
require_once('dbconnection.php');
include 'header.php';
?>
<style>
.team-section {
    background-color: #f8f8f8;
    padding: 50px 25px;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 700px;
    margin: 50px auto;
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.team-section:hover {
    transform: translateY(-3px);
}

.team-section h1 {
    font-size: 36px;
    color: #0078d7;
    margin-bottom: 25px;
    font-weight: bold;
    text-transform: uppercase;
}

.team-member {
    background-color: #ffffff;
    padding: 25px;
    margin-bottom: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.07);
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.team-member:hover {
    transform: scale(1.02);
}

.team-member strong {
    font-size: 20px;
    color: #005bb5;
    display: block;
    margin-bottom: 15px;
    text-transform: uppercase;
    font-weight: bold;
    border-bottom: 2px solid #005bb5;
    padding-bottom: 5px;
}

.team-member p {
    font-size: 18px;
    color: #333;
    margin: 12px 0;
    padding: 10px;
    background-color: #f0f0f0;
    border-radius: 8px;
    font-weight: 500;
    transition: background-color 0.3s ease-in-out;
}

.team-member p:hover {
    background-color: #e0e0e0;
}
</style>
<body>
    <div class="team-section">
        <h1>Our Team</h1>
        <div class="team-member">
            <strong>Front-end Programmers:</strong>
            <p>Hisham Bin Doheash 230164253</p>
            <p>Rene Samtani 240077411</p>
            <p>Gurvir Brar 210113442</p>
            <p>Chinedu Ukaoha 220368647</p>
        </div>
        <div class="team-member">
            <strong>Back-end Programmers:</strong>
            <p>Stan Prichard 220064118</p>
            <p>Cameron Macdonald 230172432</p>
            <p>Abdul Imran 230230053</p>
            <p>Zuber Kazi 220402701</p>
        </div>
    </div>
    <!-- Back to Top Button -->
    <div class="back-to-top-container">
        <a href="experts.php" class="back-to-top-button">BACK TO TOP ↑</a>
    </div>
    <?php include 'footer.php'; ?>
</body>
