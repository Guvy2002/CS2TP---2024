<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ps5styles.css">
    <link rel="stylesheet" href="theme-toggle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
	<script src="notifications.js"></script>
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
            background-image: linear-gradient(180deg, rgb(49, 43, 43), rgb(248, 244, 249));
        }

        .dropdown {
            position: absolute;
            background-color: blue;
            border-radius: 12px;
            max-height: 350px;
            overflow-y: auto;
            overflow-x: hidden;
            width: 100%;
            display: none;
            z-index: 1000;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            top: calc(100% + 8px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            margin-top: 5px;
        }

        .dropdown a {
            display: flex;
            padding: 14px 20px;
            text-decoration: none;
            color: #2c2c2c;
            font-size: 15px;
            background-color: blue;
            position: relative;
            align-items: center;
        }

        .dropdown a:not(:last-child) {
            border-bottom: 1px solid rgba(0, 120, 215, 0.1);
        }

        .dropdown a:hover {
            background-color: rgba(0, 120, 215, 0.1);
            color: #0078d7;
        }

        .dropdown .no-results {
            padding: 20px;
            color: #666;
            text-align: center;
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
        }


        .search-box {
            position: relative;
        }
    </style>


    <!-- Navigation Bar  -->
    <div class="navbar">
        <!-- Left Section: Navigation Links -->
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="ps5.php">PlayStation</a></li>
            <li><a href="xbox.php">XBOX</a></li>
            <li><a href="nintendo.php">Nintendo</a></li>
            <li><a href="VR.php">VR</a></li>
            <li><a href="pc.php">PC</a></li>
            <li><a href="sb.php">Special Bundles</a></li>
            <li><a href="preorder.php">Pre order</a></li>
        </ul>


        <!-- Right Section: Sign In and Basket -->
        <div class="right-section">
            <div class="search-box" style="position: relative;">
                <input type="text" id="search-bar" class="search-bar" placeholder="Search..."
                    onkeyup="fetchSuggestions(this.value)">
                <div id="search-dropdown" class="dropdown" style="position: absolute; top: 100%; left: 0; width: 100%;">
                </div>
                <button class="search-button">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Theme toggle - Sun/Moon -->
            <label class="theme-container">
                <input type="checkbox" id="theme-toggle">
                <svg viewBox="0 0 384 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="moon">
                    <path
                        d="M223.5 32C100 32 0 132.3 0 256S100 480 223.5 480c60.6 0 115.5-24.2 155.8-63.4c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6c-96.9 0-175.5-78.8-175.5-176c0-65.8 36-123.1 89.3-153.3c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z">
                    </path>
                </svg>
                <svg viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="sun">
                    <path
                        d="M361.5 1.2c5 2.1 8.6 6.6 9.6 11.9L391 121l107.9 19.8c5.3 1 9.8 4.6 11.9 9.6s1.5 10.7-1.6 15.2L446.9 256l62.3 90.3c3.1 4.5 3.7 10.2 1.6 15.2s-6.6 8.6-11.9 9.6L391 391 371.1 498.9c-1 5.3-4.6 9.8-9.6 11.9s-10.7 1.5-15.2-1.6L256 446.9l-90.3 62.3c-4.5 3.1-10.2 3.7-15.2 1.6s-8.6-6.6-9.6-11.9L121 391 13.1 371.1c-5.3-1-9.8-4.6-11.9-9.6s-1.5-10.7 1.6-15.2L65.1 256 2.8 165.7c-3.1-4.5-3.7-10.2-1.6-15.2s6.6-8.6 11.9-9.6L121 121 140.9 13.1c1-5.3 4.6-9.8 9.6-11.9s10.7-1.5 15.2 1.6L256 65.1 346.3 2.8c4.5-3.1 10.2-3.7 15.2-1.6zM160 256a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zm224 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0z">
                    </path>
                </svg>
            </label>

            <a href="wishlist.php">
                <i class="bi bi-heart"></i>
            </a>
            <a href="basket.php">
                <i class="bi bi-cart3"></i>
            </a>
            <a href="<?php echo isset($_SESSION['customerID']) ? 'myaccount.php' : 'login.php'; ?>">
                <i class="bi bi-person-circle"></i>
            </a>
        </div>
    </div>

    <script>
        async function fetchSuggestions(query) {
            const dropdown = document.getElementById("search-dropdown");
            if (query.length === 0) {
                dropdown.style.display = "none";
                return;
            }

            try {
                const response = await fetch(`searchSuggestions.php?query=${encodeURIComponent(query)}`);
                const data = await response.json();

                if (data.length > 0) {
                    dropdown.innerHTML = data
                        .map(item => `<a href="product.php?id=${item.productID}">${item.fullName}</a>`)
                        .join("");
                    dropdown.style.display = "block";
                } else {
                    dropdown.innerHTML = "<div style='padding: 8px;'>No results found</div>";
                    dropdown.style.display = "block";
                }
            } catch (error) {
                console.error("Error fetching suggestions:", error);
            }
        }


        document.addEventListener("click", (event) => {
            const dropdown = document.getElementById("search-dropdown");
            if (!event.target.closest(".search-box")) {
                dropdown.style.display = "none";
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const toggleSwitch = document.getElementById('theme-toggle');
            const currentTheme = localStorage.getItem('theme');

            if (currentTheme) {
                document.documentElement.setAttribute('data-theme', currentTheme);

                if (currentTheme === 'dark') {
                    toggleSwitch.checked = true;
                }
            }

            function switchTheme(e) {
                if (e.target.checked) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.setAttribute('data-theme', 'light');
                    localStorage.setItem('theme', 'light');
                }
            }

            toggleSwitch.addEventListener('change', switchTheme);
        });
    </script>
