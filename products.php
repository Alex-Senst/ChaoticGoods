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

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM products WHERE title LIKE :search";
$stmt = $pdo->prepare($query);
$stmt->execute(['search' => "%$search%"]);
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
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="logout.php">Log Out</a></li>
            <li><a href="products.php" class="active">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="user.php">My Profile</a></li>
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
                                <a href="details.php?id=<?= $product['id'] ?>" class="btn btn-link">More Info</a>
                                <div class="product-buttons">
                                    <form action="cart.php" method="POST">
                                        <input type="hidden" name="add" value="<?= $product['id'] ?>">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
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
