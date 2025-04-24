<?php
require 'admin_auth.php';

if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit();
}

$product_id = $_GET['id'];
$stmt = $con->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found.";
    exit();
}

$product = $result->fetch_assoc();
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $type = $_POST['type'];

    $stmt = $con->prepare("UPDATE products SET title = ?, description = ?, price = ?, color = ?, type = ? WHERE product_id = ?");
    $stmt->bind_param("ssdssi", $title, $desc, $price, $color, $type, $product_id);
    $stmt->execute();

    header("Location: manage_products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php">Admin Dashboard</a></li>
                <li><a href="manage_products.php" class="active">Manage Products</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
            </div>
        </div>

        <div class="content">
            <h2>Edit Product</h2>
            <form method="POST">
                <label>Title:</label><br>
                <input type="text" name="title" value="<?= htmlspecialchars($product['title']) ?>"><br>

                <label>Description:</label><br>
                <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea><br>

                <label>Price:</label><br>
                <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"><br>

                <label>Color:</label><br>
                <input type="text" name="color" value="<?= htmlspecialchars($product['color']) ?>"><br>

                <label>Type:</label><br>
                <input type="text" name="type" value="<?= htmlspecialchars($product['type']) ?>"><br>

                <button type="submit">Update Product</button>
            </form>

            <a href="manage_products.php">← Back to Products</a>
        </div>
    </div>
</body>
</html>

