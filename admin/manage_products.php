<?php
require 'admin_auth.php'; // assumes your auth is in this file

$result = $con->query("SELECT * FROM products ORDER BY created_at DESC");
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
            <h2>All Products</h2>
            <a href="add_product.php">Add New Product</a>
            <table border="1">
            <tr>
                <th>Title</th><th>Price</th><th>Seller</th><th>Actions</th>
            </tr>
            <?php while ($product = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($product['title']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['seller_id'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $product['product_id'] ?>">Edit</a> |
                    <a href="delete_product.php?id=<?= $product['product_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
