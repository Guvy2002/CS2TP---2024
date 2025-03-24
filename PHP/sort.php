<?php

$minPrice = isset($_GET['minPrice']) ? floatval($_GET['minPrice']) : 0;
$maxPrice = isset($_GET['maxPrice']) ? floatval($_GET['maxPrice']) : 1000;
$inStock = isset($_GET['inStock']) ? (bool)$_GET['inStock'] : false;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'popular';


function getFilteredProducts($categoryID, $conn) {
    global $minPrice, $maxPrice, $inStock, $sort;
    
    $sql = "SELECT * FROM Products WHERE categoryID = ? AND Price BETWEEN ? AND ?";
    
    if ($inStock) {
        $sql .= " AND stockQuantity > 0";
    }
    
    switch ($sort) {
        case 'price-low':
            $sql .= " ORDER BY Price ASC";
            break;
        case 'price-high':
            $sql .= " ORDER BY Price DESC";
            break;
        case 'name-az':
            $sql .= " ORDER BY fullName ASC";
            break;
        case 'name-za':
            $sql .= " ORDER BY fullName DESC";
            break;
        case 'newest':
            $sql .= " ORDER BY productID DESC";
            break;
        default:
            $sql .= " ORDER BY productID ASC"; 
    }
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("sdd", $categoryID, $minPrice, $maxPrice);
    
    return $stmt;
}
?>