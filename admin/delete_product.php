<?php
require 'admin_auth.php';

if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit();
}

$product_id = $_GET['id'];

// Optional: Check if product exists first
$stmt = $con->prepare("DELETE FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();

header("Location: manage_products.php");
exit();
?>
