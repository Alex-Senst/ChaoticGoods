<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'] ?? 0;
$order_id = $_GET['order_id'] ?? 0;

// Redirect to login if not logged in
if (!$user_id) {
    $_SESSION['redirect_to_cart'] = ['reorder' => $order_id];
    header("Location: login.php");
    exit();
}

// Step 1: Get products from the given order
$stmt = $con->prepare("
    SELECT product_id, quantity 
    FROM order_details 
    WHERE order_id = (
        SELECT order_id FROM orders 
        WHERE order_id = ? AND user_id = ?
    )
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Step 2: Add each product to the user's cart
while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];

    $addStmt = $con->prepare("
        INSERT INTO cart_items (user_id, product_id, quantity) 
        VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE quantity = quantity + ?
    ");
    $addStmt->bind_param("iiii", $user_id, $product_id, $quantity, $quantity);
    $addStmt->execute();
}

// Step 3: Redirect to cart
header("Location: cart.php");
exit();
?>
