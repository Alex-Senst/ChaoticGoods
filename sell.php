<?php
require("db.php");
session_start();
if (!isset($_SESSION['user-id'])) {
    die("You must be logged in to sell products.");
}

$host = 'localhost';
$dbname = 'chaotic_goods';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate user input
    $title = trim($_POST["title"]);
    $price = trim($_POST["price"]);
    $image_url = trim($_POST["image_url"]);
    $description = trim($_POST["description"]);
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($price) || empty($image_url) || empty($description)) {
        die("All fields are required.");
    }

    $query = "INSERT INTO products (title, price, image_url, description, seller_id) 
              VALUES (:title, :price, :image_url, :description, :seller_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'title' => $title,
        'price' => $price,
        'image_url' => $image_url,
        'description' => $description,
        'seller_id' => $user_id
    ]);

    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sell a Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
                max-width: 600px;
                margin-left: 300px;
        }
        form {
            margin-top: 20px;
        }
        form label {
            margin-top: 10px;
            font-weight: bold;
        }
        form input, form textarea, form button {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
        }
        h2{
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="logout.php">Log Out</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="user.php">My Profile</a></li>
            <li><a href="sell.php" class="active">Sell an Item</a></li>
        </ul>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
    </div>

    <div class="container">
        <h2>Sell a Product</h2>
        <form action="sell.php" method="POST">
            <label>Title:</label>
            <input type="text" name="title" required>
            
            <label>Price:</label>
            <input type="number" name="price" step="0.01" required>
            
            <label>Image URL:</label>
            <input type="text" name="image_url" required>
            
            <label>Description:</label>
            <textarea name="description" required></textarea>
            
            <button type="submit">Sell</button>
        </form>
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

