<?php
$currentPage = basename($_SERVER['PHP_SELF']);

$minPrice = isset($_GET['minPrice']) ? floatval($_GET['minPrice']) : 20;
$maxPrice = isset($_GET['maxPrice']) ? floatval($_GET['maxPrice']) : 350;
$inStock = isset($_GET['inStock']) ? (bool) $_GET['inStock'] : false;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'popular';


$categoryIds = array_values($categories);
$currentCategory = $categoryIds[0] ?? 10;

if ($conn) {
    $categoryIDList = implode(',', $categoryIds);

    $priceQuery = $conn->query("SELECT MIN(Price) as minPrice, MAX(Price) as maxPrice FROM Products WHERE categoryID IN ($categoryIDList)");

    if ($priceQuery && $priceRow = $priceQuery->fetch_assoc()) {
        $dbMinPrice = floor($priceRow['minPrice']);
        $dbMaxPrice = ceil($priceRow['maxPrice']);

        if (!isset($_GET['minPrice'])) {
            $minPrice = $dbMinPrice;
        }

        if (!isset($_GET['maxPrice'])) {
            $maxPrice = $dbMaxPrice;
        }
    }
}

$dbMinPrice = $dbMinPrice ?? 20;
$dbMaxPrice = $dbMaxPrice ?? 350;
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<button id="openFilterBtn" class="filter-btn">
    <i class="bi bi-funnel"></i>
</button>

<div id="filterSidebar" class="filter-sidebar">
    <div class="filter-header">
        <button id="closeFilterBtn" class="close-filter-btn">
            <i class="bi bi-arrow-left"></i> Filter
        </button>
    </div>

    <form id="filterForm" action="<?php echo $currentPage; ?>" method="GET">
        <div class="filter-content">
            <div class="filter-section">
                <h3>Sort by</h3>
                <div class="sort-options">
                    <label class="sort-option">
                        <input type="radio" name="sort" value="popular" <?php echo $sort == 'popular' ? 'checked' : ''; ?>>
                        <span class="radio-circle"></span>
                        <span class="radio-label">Most Popular</span>
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="price-low" <?php echo $sort == 'price-low' ? 'checked' : ''; ?>>
                        <span class="radio-circle"></span>
                        <span class="radio-label">Price (Low to High)</span>
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="price-high" <?php echo $sort == 'price-high' ? 'checked' : ''; ?>>
                        <span class="radio-circle"></span>
                        <span class="radio-label">Price (High to Low)</span>
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="name-az" <?php echo $sort == 'name-az' ? 'checked' : ''; ?>>
                        <span class="radio-circle"></span>
                        <span class="radio-label">Name: A to Z</span>
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="name-za" <?php echo $sort == 'name-za' ? 'checked' : ''; ?>>
                        <span class="radio-circle"></span>
                        <span class="radio-label">Name: Z to A</span>
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="newest" <?php echo $sort == 'newest' ? 'checked' : ''; ?>>
                        <span class="radio-circle"></span>
                        <span class="radio-label">Newest</span>
                    </label>
                </div>
            </div>

            <div class="filter-section">
                <h3>Price</h3>
                <div class="price-range-display">£<span id="minPriceDisplay"><?php echo $minPrice; ?></span> - £<span
                        id="maxPriceDisplay"><?php echo $maxPrice; ?></span></div>
                <div class="price-slider-container">
                    <input type="range" min="<?php echo $dbMinPrice; ?>" max="<?php echo $dbMaxPrice; ?>"
                        value="<?php echo $minPrice; ?>" class="range-slider min-slider" id="minPriceSlider"
                        name="minPrice">
                    <input type="range" min="<?php echo $dbMinPrice; ?>" max="<?php echo $dbMaxPrice; ?>"
                        value="<?php echo $maxPrice; ?>" class="range-slider max-slider" id="maxPriceSlider"
                        name="maxPrice">
                    <div class="slider-track"></div>
                </div>
            </div>

            <div class="filter-section stock-section">
                <div class="stock-toggle">
                    <span>In Stock</span>
                    <label class="switch">
                        <input type="checkbox" name="inStock" value="1" <?php echo $inStock ? 'checked' : ''; ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="filter-actions-fixed">
                <button type="button" id="clearFiltersBtn" class="clear-btn">Clear all</button>
                <button type="button" id="applyFiltersBtn" class="apply-btn">Apply filters</button>
            </div>
        </div>
    </form>
</div>

<div id="filterOverlay" class="filter-overlay"></div>


<style>
    .filter-sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: 100%;
        max-width: 400px;
        height: 100%;
        background-color: var(--card-bg);
        z-index: 2000;
        overflow-y: auto;
        transition: left 0.3s ease-in-out;
        box-shadow: 2px 0 10px var(--card-shadow);
    }

    .filter-sidebar.active {
        left: 0;
    }

    .filter-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1999;
        display: none;
    }

    .filter-overlay.active {
        display: block;
    }

    .filter-header {
        padding: 16px;
        border-bottom: 1px solid var(--card-border);
        position: sticky;
        top: 0;
        background-color: var(--card-bg);
        z-index: 10;
    }

    .close-filter-btn {
        background: none;
        border: none;
        font-size: 18px;
        font-weight: normal;
        cursor: pointer;
        display: flex;
        align-items: center;
        padding: 0;
        color: var(--text-color);
    }

    .close-filter-btn i {
        margin-right: 10px;
    }

    .filter-content {
        padding-bottom: 80px;
    }

    .filter-section {
        padding: 16px;
        border-bottom: 1px solid var(--card-border);
    }

    .filter-section h3 {
        font-size: 16px;
        margin: 0 0 16px 0;
        color: var(--heading-color);
        text-align: left;
    }

    .sort-options {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sort-option {
        display: flex;
        align-items: center;
        position: relative;
        padding-left: 36px;
        cursor: pointer;
    }

    .sort-option input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .radio-circle {
        position: absolute;
        left: 0;
        height: 24px;
        width: 24px;
        background-color: var(--card-bg);
        border: 2px solid var(--card-border);
        border-radius: 50%;
    }

    .sort-option:hover .radio-circle {
        border-color: var(--heading-color);
        opacity: 0.7;
    }

    .sort-option input:checked~.radio-circle {
        border-color: var(--heading-color);
        background-color: var(--card-bg);
    }

    .radio-circle:after {
        content: "";
        position: absolute;
        display: none;
        top: 4px;
        left: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--heading-color);
    }

    .sort-option input:checked~.radio-circle:after {
        display: block;
    }

    .radio-label {
        font-size: 16px;
        color: var(--text-color);
    }

    .price-slider-container {
        position: relative;
        width: 100%;
        height: 40px;
        margin: 10px 0 20px 0;
    }

    .range-slider {
        position: absolute;
        pointer-events: none;
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        height: 100%;
        background: none;
        top: 0;
        left: 0;
    }

    .range-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--heading-color);
        border: 2px solid var(--card-bg);
        box-shadow: 0 0 5px var(--card-shadow);
        cursor: pointer;
        pointer-events: auto;
        margin-top: -14px;
        position: relative;
        z-index: 1;
    }

    .range-slider::-moz-range-thumb {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--heading-color);
        border: 2px solid var(--card-bg);
        box-shadow: 0 0 5px var(--card-shadow);
        cursor: pointer;
        pointer-events: auto;
        position: relative;
        z-index: 1;
    }

    .min-slider {
        z-index: 2;
    }

    .max-slider {
        z-index: 1;
    }

    .slider-track {
        position: absolute;
        width: 100%;
        height: 4px;
        background: var(--card-border);
        top: 50%;
        transform: translateY(-50%);
        border-radius: 2px;
    }

    .price-range-display {
        font-size: 16px;
        margin-bottom: 16px;
        font-weight: bold;
        color: var(--text-color);
    }

    .stock-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stock-toggle span {
        font-size: 16px;
        color: var(--text-color);
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: var(--card-border);
        transition: .4s;
    }

    .switch .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: var(--card-bg);
        transition: .4s;
    }

    .switch input:checked+.slider {
        background-color: var(--heading-color);
    }

    .switch input:checked+.slider:before {
        transform: translateX(24px);
    }

    .switch .slider.round {
        border-radius: 34px;
    }

    .switch .slider.round:before {
        border-radius: 50%;
    }

    .filter-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: var(--heading-color);
        color: var(--card-bg);
        border: none;
        font-size: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        box-shadow: 0 2px 10px var(--card-shadow);
    }

    .filter-actions-fixed button {
        width: 48%;
        padding: 12px 0;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        text-align: center;
    }

    .clear-btn {
        background-color: var(--card-bg);
        color: var(--heading-color);
        border: 1px solid var(--heading-color);
    }

    .apply-btn {
        background-color: var(--heading-color);
        color: var(--card-bg);
        border: none;
    }

    body {
        padding-bottom: 70px;
    }

    @media (max-width: 768px) {
        .filter-sidebar {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openFilterBtn = document.getElementById('openFilterBtn');
        const filterSidebar = document.getElementById('filterSidebar');
        const closeFilterBtn = document.getElementById('closeFilterBtn');
        const filterOverlay = document.getElementById('filterOverlay');
        const clearFiltersBtn = document.getElementById('clearFiltersBtn');
        const applyFiltersBtn = document.getElementById('applyFiltersBtn');
        const filterForm = document.getElementById('filterForm');

        const minSlider = document.getElementById('minPriceSlider');
        const maxSlider = document.getElementById('maxPriceSlider');
        const minDisplay = document.getElementById('minPriceDisplay');
        const maxDisplay = document.getElementById('maxPriceDisplay');

        openFilterBtn.addEventListener('click', function () {
            filterSidebar.classList.add('active');
            filterOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        function closeFilterSidebar() {
            filterSidebar.classList.remove('active');
            filterOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        closeFilterBtn.addEventListener('click', closeFilterSidebar);
        filterOverlay.addEventListener('click', closeFilterSidebar);

        if (minDisplay && maxDisplay && minSlider && maxSlider) {
            minDisplay.textContent = minSlider.value;
            maxDisplay.textContent = maxSlider.value;

            minSlider.addEventListener('input', function () {
                if (parseInt(minSlider.value) > parseInt(maxSlider.value)) {
                    minSlider.value = maxSlider.value;
                }
                minDisplay.textContent = minSlider.value;
            });
            maxSlider.addEventListener('input', function () {
                if (parseInt(maxSlider.value) < parseInt(minSlider.value)) {
                    maxSlider.value = minSlider.value;
                }
                maxDisplay.textContent = maxSlider.value;
            });
        }

        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', function () {
                window.location.href = '<?php echo $currentPage; ?>';
            });
        }

        if (applyFiltersBtn && filterForm) {
            applyFiltersBtn.addEventListener('click', function () {
                filterForm.submit();
            });
        }
    });
</script>