<?php
require_once("dbconnection.php");

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    
    if (empty($query)) {
        echo json_encode([]);
        exit();
    }
    
    $searchTerms = explode(' ', $query);
    $searchConditions = [];
    $paramTypes = '';
    $bindParams = [];
    
    foreach ($searchTerms as $term) {
        if (strlen($term) < 1) continue; 
        
        $searchConditions[] = "(fullName LIKE ? OR Description LIKE ? OR ModelNo LIKE ?)";
        $paramTypes .= "sss";
        $formattedTerm = "%" . $term . "%";
        $bindParams[] = $formattedTerm;
        $bindParams[] = $formattedTerm;
        $bindParams[] = $formattedTerm;
    }
    
    if (empty($searchConditions)) {
        echo json_encode([]);
        exit();
    }
    
    $sql = "SELECT p.productID, p.fullName, p.Price, p.imgURL, c.categoryName 
            FROM Products p
            JOIN Category c ON p.categoryID = c.categoryID
            WHERE " . implode(' AND ', $searchConditions) . " 
            ORDER BY 
                CASE WHEN fullName LIKE ? THEN 0 ELSE 1 END,
                LENGTH(fullName) ASC
            LIMIT 10";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $paramTypes .= "s";
        $exactMatch = $query . "%";
        $bindParams[] = $exactMatch;
        
        $bindParamArgs = [$paramTypes];
        foreach ($bindParams as $key => $value) {
            $bindParamArgs[] = &$bindParams[$key];
        }
        
        call_user_func_array([$stmt, 'bind_param'], $bindParamArgs);
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $suggestions = [];
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = [
                'productID' => $row['productID'],
                'fullName' => $row['fullName'],
                'price' => $row['Price'],
                'imgURL' => $row['imgURL'],
                'category' => $row['categoryName']
            ];
        }
        
        $stmt->close();
    } else {
        $suggestions = [];
        error_log("Search query preparation failed: " . $conn->error);
    }
    
    header('Content-Type: application/json');
    echo json_encode($suggestions);
    exit();
}
?>