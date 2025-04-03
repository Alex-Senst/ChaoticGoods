<?php

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

// Get selected filter values
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$selected_color = isset($_GET['color']) ? $_GET['color'] : '';
$selected_type = isset($_GET['type']) ? $_GET['type'] : '';

// Build the SQL query with optional filtering
$query = "SELECT p.*, u.username AS seller_name 
          FROM products p 
          LEFT JOIN users u ON p.seller_id = u.user_id 
          WHERE p.title LIKE :search";

// Add condition for color if selected
if ($selected_color) {
    $query .= " AND p.color = :color";
}

// Add condition for type if selected
if ($selected_type) {
    $query .= " AND p.type = :type";
}

// Add condition for price range if provided
if (isset($_GET['min_price']) && $_GET['min_price'] !== '') {
    $query .= " AND p.price >= :min_price";
}
if (isset($_GET['max_price']) && $_GET['max_price'] !== '') {
    $query .= " AND p.price <= :max_price";
}

// Prepare the statement
$stmt = $pdo->prepare($query);

// Bind parameters for search, color, type, and price
$params = ['search' => "%$search%"];
if ($selected_color) {
    $params['color'] = $selected_color;
}
if ($selected_type) {
    $params['type'] = $selected_type;
}
if (isset($_GET['min_price']) && $_GET['min_price'] !== '') {
    $params['min_price'] = $_GET['min_price'];
}
if (isset($_GET['max_price']) && $_GET['max_price'] !== '') {
    $params['max_price'] = $_GET['max_price'];
}

// Execute the query
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .product-card {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            margin-left: 20px;
            width: 100%;
        }

        .product-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product-card .product-info {
            margin-left: 15px;
        }

        .product-title {
            font-size: 18px;
            font-weight: bold;
        }

        .product-price {
            font-size: 16px;
            color: #2d72d9;
            margin: 10px 0;
        }

        .product-buttons {
            margin-top: 15px;
        }
        .search-bar {
            margin-bottom: 30px;
            max-width: 900px;
            margin-left: 20px;
            margin-right: auto;
        }
        .container {
            margin-right: 300px;
            padding-top: 20px;
        }
        .no-products-message {
            margin-left: 35px;  /* Adjust the value to your preference */
        }
    </style>
</head>
<body>
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

    <div class="container">
        <!-- Search Bar -->
        <form method="GET" class="search-bar">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">

            <!-- Filter by Color -->
            <select name="color" class="form-control mt-2">
                <option value="">Select Color</option>
                <option value="red" <?= isset($_GET['color']) && $_GET['color'] == 'red' ? 'selected' : '' ?>>Red</option>
                <option value="orange" <?= isset($_GET['color']) && $_GET['color'] == 'orange' ? 'selected' : '' ?>>Orange</option>
                <option value="yellow" <?= isset($_GET['color']) && $_GET['color'] == 'yellow' ? 'selected' : '' ?>>Yellow</option>
                <option value="green" <?= isset($_GET['color']) && $_GET['color'] == 'green' ? 'selected' : '' ?>>Green</option>
                <option value="blue" <?= isset($_GET['color']) && $_GET['color'] == 'blue' ? 'selected' : '' ?>>Blue</option>
                <option value="purple" <?= isset($_GET['color']) && $_GET['color'] == 'purple' ? 'selected' : '' ?>>Purple</option>
                <option value="black" <?= isset($_GET['color']) && $_GET['color'] == 'black' ? 'selected' : '' ?>>Black</option>
                <option value="white" <?= isset($_GET['color']) && $_GET['color'] == 'white' ? 'selected' : '' ?>>White</option>
            </select>

            <!-- Filter by Type -->
            <select name="type" class="form-control mt-2">
                <option value="">Select Type</option>
                <option value="book" <?= isset($_GET['type']) && $_GET['type'] == 'book' ? 'selected' : '' ?>>Books</option>
                <option value="dice" <?= isset($_GET['type']) && $_GET['type'] == 'dice' ? 'selected' : '' ?>>Dice</option>
                <option value="bag" <?= isset($_GET['type']) && $_GET['type'] == 'bag' ? 'selected' : '' ?>>Bags</option>
                <option value="sticker" <?= isset($_GET['type']) && $_GET['type'] == 'sticker' ? 'selected' : '' ?>>Stickers</option>
            </select>

            <div class="mt-2">
                <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="<?= isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : '' ?>">
            </div>
            <div class="mt-2">
                <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="<?= isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : '' ?>">
            </div>

            <button type="submit" class="btn btn-primary mt-2">Apply Filters</button>
            <a href="products.php" class="btn btn-secondary mt-2">Reset Filters</a>
        </form>

        <div class="row">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3">
                        <div class="product-card">
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Product Image">
                            <div class="product-info">
                                <div class="product-title"><?= htmlspecialchars($product['title']) ?></div>
                                <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
                                
                                <?php if (!empty($product['seller_name'])): ?>
                                    <div class="product-seller">Sold by: <?= htmlspecialchars($product['seller_name']) ?></div>
                                <?php else: ?>
                                    <div class="product-seller">Sold by: Admin</div>
                                <?php endif; ?>

                                <a href="details.php?id=<?= $product['product_id'] ?>" class="btn btn-link">More Info</a>
                                <div class="product-buttons">
                                    <form action="cart.php" method="POST">
                                        <input type="hidden" name="add" value="<?= $product['product_id'] ?>">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-products-message">
                        <p>No products found.</p>
                    </div>
                <?php endif; ?>

        </div>
    </div>

    <footer>
        <p>ChaoticGoods</p>
        <p><a href="about.php">About</a></p>
        <p><a href="contact.php">Contact</a></p>
        <p><a href="cookies.php">Cookies</a></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
