<?php
require_once('dbconnection.php');  // Include the database connection

// Check if the search term is passed via GET
if (isset($_GET['search'])) {
    // Sanitize user input to prevent SQL injection
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);

    // SQL query to search for products by fullName or Description
    $query = "SELECT * FROM Products WHERE fullName LIKE '%$searchQuery%' OR Description LIKE '%$searchQuery%'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if there are results
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Search Results:</h2>";
        echo "<ul>";

        // Loop through the results and display them
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($row['fullName']) . "</strong><br>";
            echo "Description: " . htmlspecialchars($row['Description']) . "<br>";
            echo "Price: $" . htmlspecialchars($row['Price']) . "<br>";
            echo "</li><br>";
        }

        echo "</ul>";
    } else {
        // If no results are found
        echo "<p>No results found for <strong>" . htmlspecialchars($searchQuery) . "</strong></p>";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="ps5styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
</head>

<body>

    <div class="grad3">
        <img src="images/GamePointLogo.png" class="logo" alt="GamePoint Logo">
        <h2>GamePoint</h2>
    </div>

    <style>
        .grad3 {
            height: 100px;
            background-color: red;
            /* For browsers that do not support gradients */
            background-image: linear-gradient(180deg, rgb(49, 43, 43), rgb(248, 244, 249));
        }
    </style>


    <!-- Navigation Bar  -->
    <div class="navbar">
        <!-- Left Section: Navigation Links -->
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


        <!-- Right Section: Sign In and Basket -->
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