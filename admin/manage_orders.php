<?php
require 'admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $con->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
}

$result = $con->query("
    SELECT o.order_id, o.full_name, o.status, o.created_at, u.username
    FROM orders o JOIN users u ON o.user_id = u.user_id
    ORDER BY o.created_at DESC
");
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
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="manage_orders.php" class="active">Manage Orders</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
            </div>
        </div>

        <div class="content">
            <table border="1">
            <tr>
                <th>Order ID</th><th>Customer</th><th>Status</th><th>Change</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['order_id'] ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?> (<?= $row['username'] ?>)</td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                        <select name="status">
                            <option>Pending</option>
                            <option>Shipped</option>
                            <option>Delivered</option>
                            <option>Cancelled</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>

