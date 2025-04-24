<?php
require 'admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $type = $_POST['type'];

    // Handle image upload
    $image_url = '';
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_tmp = $_FILES['image_file']['tmp_name'];
        $file_name = basename($_FILES['image_file']['name']);
        $file_path = $upload_dir . uniqid() . "_" . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $image_url = $file_path;
        } else {
            echo "Image upload failed.";
            exit();
        }
    }

    $seller_id = $_SESSION['user_id'];

    $stmt = $con->prepare("INSERT INTO products (title, description, price, color, type, seller_id, image_url, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssdssis", $title, $desc, $price, $color, $type, $seller_id, $image_url);
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
                <li><a href="dashboard.php" class="active">Admin Dashboard</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
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
            <h2>Add Product</h2>
            <form method="POST" enctype="multipart/form-data">
                <input name="title" placeholder="Title" required><br>
                <textarea name="description" placeholder="Description" required></textarea><br>
                <input name="price" type="number" step="0.01" placeholder="Price" required><br>
                <input name="color" placeholder="Color"><br>
                <input name="type" placeholder="Type"><br>

                <label>Upload Image:</label><br>
                <input type="file" name="image_file" accept="image/*" required><br>

                <button type="submit">Add Product</button>
            </form>

            <a href="manage_products.php">← Back to Products</a>
        </div>
    </div>
</body>
</html>
