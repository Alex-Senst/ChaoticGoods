<?php
require 'db.php'; // Or wherever your DB connection is

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

$query = "
    SELECT od.product_name, od.quantity, od.price, o.order_date, o.status 
    FROM order_details od 
    JOIN orders o ON od.order_id = o.order_id 
    WHERE od.order_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Order not found.";
    exit;
}
$order_items = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order #<?= htmlspecialchars($order_id) ?> Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Or bootstrap -->
</head>
<body>
    <div class="container">
        <h2>Order #<?= htmlspecialchars($order_id) ?> Details</h2>
        <p>Order Date: <?= htmlspecialchars($order_items[0]['order_date']) ?></p>
        <p>Status: <?= htmlspecialchars($order_items[0]['status']) ?></p>

        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td>$<?= htmlspecialchars($item['price']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="user.php">← Back to Dashboard</a></p>
    </div>
</body>
</html>
