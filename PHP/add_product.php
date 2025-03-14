<?php
session_start();
require_once("dbconnection.php");

//security check for admin
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = trim($_POST['productName']);
    $modelNo = trim($_POST['ModelNo']);
    $category = (int)$_POST['category'];
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $description = trim($_POST['description']);

    
    $errors = [];
    if (empty($productName)) {
        $errors[] = "Product name is required";
    }
    if (empty($modelNo)) {
        $errors[] = "Model number is required";
    }
    if ($price <= 0) {
        $errors[] = "Price must be greater than 0";
    }
    if ($stock < 0) {
        $errors[] = "Stock cannot be negative";
    }

    
    $checkSql = "SELECT productID FROM Products WHERE ModelNo = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $modelNo);
    $checkStmt->execute();
    if ($checkStmt->get_result()->num_rows > 0) {
        $errors[] = "Model number already exists";
    }
    $checkStmt->close();

    
    $imgURL = '';
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/avif' => 'avif'
        ];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!array_key_exists($_FILES['product_image']['type'], $allowedTypes)) {
            $errors[] = "Invalid file type. Only JPG, PNG, GIF, WEBP, and AVIF are allowed.";
        } elseif ($_FILES['product_image']['size'] > $maxSize) {
            $errors[] = "File is too large. Maximum size is 5MB.";
        } else {
            
            $uploadDir = 'images/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

           
            $fileExtension = $allowedTypes[$_FILES['product_image']['type']];
            $fileName = strtolower(str_replace(['/', '\\', ' '], '-', $modelNo)) . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath)) {
                $imgURL = $targetPath;
            } else {
                $errors[] = "Failed to upload image.";
            }
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO Products (fullName, ModelNo, categoryID, Price, stockQuantity, Description, imgURL, Supplier) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NULL)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssidiss", $productName, $modelNo, $category, $price, $stock, $description, $imgURL);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Product added successfully!";
            header('Location: inventory_dashboard.php');
            exit();
        } else {
            $errors[] = "Error adding product: " . $conn->error;
            
            if (!empty($imgURL) && file_exists($imgURL)) {
                unlink($imgURL);
            }
        }
        $stmt->close();
    }
}


$categorySql = "SELECT categoryID, categoryName FROM Category ORDER BY categoryName";
$categories = $conn->query($categorySql)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Product</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --danger-color: #ff4d6d;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            line-height: 1.6;
            color: var(--dark-color);
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h1 {
            font-size: 1.8rem;
            color: var(--dark-color);
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-1px);
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .errors {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #f5c2c7;
            border-radius: 8px;
            color: #842029;
            background-color: #f8d7da;
        }

        .errors ul {
            margin: 0;
            padding-left: 20px;
        }

        .image-preview {
            max-width: 300px;
            margin: 10px 0;
            border: 2px dashed #ccc;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
        }

        .image-preview img {
            max-width: 100%;
            height: auto;
            display: none;
            border-radius: 4px;
        }

        .image-preview.has-image {
            border: none;
            padding: 0;
        }

        .text-muted {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 20px auto;
            }

            .card {
                padding: 20px;
            }

            .card-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .form-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1><i class="fas fa-plus"></i> Add New Product</h1>
                <a href="inventory_dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data" id="addProductForm">
                <div class="form-group">
                    <label for="productName">Product Name *</label>
                    <input type="text" id="productName" name="productName" class="form-control" 
                           value="<?php echo isset($_POST['productName']) ? htmlspecialchars($_POST['productName']) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="ModelNo">Model Number *</label>
                    <input type="text" id="ModelNo" name="ModelNo" class="form-control" 
                           value="<?php echo isset($_POST['ModelNo']) ? htmlspecialchars($_POST['ModelNo']) : ''; ?>" 
                           required>
                    <small class="text-muted">Must be unique. Used for identification.</small>
                </div>

                <div class="form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['categoryID']; ?>"
                                    <?php echo (isset($_POST['category']) && $_POST['category'] == $category['categoryID']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['categoryName']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Price (£) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" class="form-control" 
                           value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="stock">Initial Stock *</label>
                    <input type="number" id="stock" name="stock" min="0" class="form-control" 
                           value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control"><?php 
                        echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; 
                    ?></textarea>
                </div>

                <div class="form-group">
                    <label for="product_image">Product Image</label>
                    <input type="file" id="product_image" name="product_image" class="form-control" 
                           accept="image/jpeg,image/png,image/gif,image/webp,image/avif" onchange="previewImage(this);">
                    <div class="image-preview" id="imagePreview">
                        <img src="#" alt="Image preview">
                        <p class="no-image-text">No image selected</p>
                    </div>
                    <small class="text-muted">Maximum file size: 5MB. Allowed formats: JPG, PNG, GIF, WEBP, AVIF</small>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Add Product
                    </button>
                    <a href="inventory_dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');
            const noImageText = preview.querySelector('.no-image-text');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.add('has-image');
                    img.style.display = 'block';
                    if (noImageText) noImageText.style.display = 'none';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                img.src = '#';
                preview.classList.remove('has-image');
                img.style.display = 'none';
                if (noImageText) noImageText.style.display = 'block';
            }
        }

        
        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            const productName = document.getElementById('productName').value.trim();
            const modelNo = document.getElementById('ModelNo').value.trim();
            const price = document.getElementById('price').value;
            const stock = document.getElementById('stock').value;
            const category = document.getElementById('category').value;
            let hasError = false;
            let errorMessage = '';

            if (!productName) {
                errorMessage += 'Product name is required\n';
                hasError = true;
            }

            if (!modelNo) {
                errorMessage += 'Model number is required\n';
                hasError = true;
            }

            if (price <= 0) {
                errorMessage += 'Price must be greater than 0\n';
                hasError = true;
            }

            if (stock < 0) {
                errorMessage += 'Stock cannot be negative\n';
                hasError = true;
            }

            if (!category) {
                errorMessage += 'Please select a category\n';
                hasError = true;
            }

            const imageInput = document.getElementById('product_image');
            if (imageInput.files.length > 0) {
                const file = imageInput.files[0];
                const fileSize = file.size / 1024 / 1024; // Convert to MB
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
                
                if (!allowedTypes.includes(file.type)) {
                    errorMessage += 'Invalid file type. Only JPG, PNG, GIF, WEBP, and AVIF are allowed\n';
                    hasError = true;
                }
                
                if (fileSize > 5) {
                    errorMessage += 'File is too large. Maximum size is 5MB\n';
                    hasError = true;
                }
            }

            if (hasError) {
                e.preventDefault();
                alert(errorMessage);
            }
        });

        
        document.getElementById('ModelNo').addEventListener('input', function(e) {
            const input = e.target;
            const value = input.value;
            const sanitized = value.replace(/[^a-zA-Z0-9-]/g, '');
            
            if (value !== sanitized) {
                input.value = sanitized;
                alert('Model number can only contain letters, numbers, and hyphens');
            }
        });

        
        document.getElementById('price').addEventListener('input', function(e) {
            const input = e.target;
            const value = input.value;
            
            if (!/^\d*\.?\d{0,2}$/.test(value)) {
                input.value = value.substring(0, value.length - 1);
            }
        });
    </script>
</body>
</html>
