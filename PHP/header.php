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
            <a href="wishlist.php">
                <i class="bi bi-heart"></i>
            </a>
            <a href="basket.php">
                <i class="bi bi-cart3"></i>
            </a>
            <a href="login.php">
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
    </script>