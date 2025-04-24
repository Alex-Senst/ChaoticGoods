<?php
// Database connection setup (same as in your products page)
$host = 'localhost';
$dbname = 'chaotic_goods';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product from DB
$query = "SELECT p.*, u.username AS seller_name 
          FROM products p 
          LEFT JOIN users u ON p.seller_id = u.user_id 
          WHERE p.product_id = :product_id";

$stmt = $pdo->prepare($query);
$stmt->execute(['product_id' => $product_id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['title']) ?> - Product Details</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .wrapper {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .wrapper img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .wrapper h3 {
            font-family: 'Lucida Console', monospace;
            color: darkgreen;
            margin: 0;
            font-size: 24px;
        }

        .text {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .product-buttons .btn {
            background-color: #007bff; /* Bootstrap Blue */
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-buttons .btn:hover {
            background-color: #0056b3;
        }


        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <ul>
        <li><a href="logout.php">Log Out</a></li>
        <li><a href="products.php" class="active">Products</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="user.php">My Profile</a></li>
        <li><a href="sell.php">Sell an Item</a></li>
    </ul>
    <div class="social-icons">
        <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
        <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
        <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
    </div>
</div>

<!-- Main Content -->
<div class="content">
    <h2>Product Details</h2>
    <div class="product-card">
        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Product Image" class="product-image">
        <h3><?= htmlspecialchars($product['title']) ?></h3>
        <p class="description"><?= htmlspecialchars($product['description']) ?></p>
        <p class="price">Price: $<?= htmlspecialchars($product['price']) ?></p>
        <p class="seller">Seller: <?= htmlspecialchars($product['seller_name']) ?></p>

        <div class="product-buttons">
            <form action="cart.php" method="POST">
                <input type="hidden" name="add" value="<?= $product['product_id'] ?>">
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
        <p><a href="products.php" style="color: #007bff; text-decoration: none;">&larr; Back to Products</a></p>
    </div>

</div>
</body>
</html>
