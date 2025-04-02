<?php
session_start();

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Calculate total cost
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $payment = $_POST['payment'];

    if (!empty($name) && !empty($address) && !empty($payment)) {
        // Simulate order placement (save to database or email)
        $_SESSION['cart'] = []; // Clear cart after checkout
        header("Location: success.php");
        exit();
    } else {
        $error = "Please fill out all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Checkout</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Payment Method</label>
                <select name="payment" class="form-control">
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="cash_on_delivery">Cash on Delivery</option>
                </select>
            </div>
            <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>
            <button type="submit" class="btn btn-success btn-block">Place Order</button>
        </form>
        <a href="cart.php" class="btn btn-secondary btn-block mt-2">Back to Cart</a>
    </div>
</body>
</html>
