<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $shipping_address = $_POST['shipping_address'];
    $billing_address = $_POST['billing_address'];
    $payment_method = $_POST['payment']; // 'credit_card', 'paypal', or 'cash_on_delivery'
    $user_id = $_SESSION['user-id'] ?? 0;

    if (!empty($name) && !empty($shipping_address) && !empty($billing_address) && !empty($payment_method)) {
        
        // Insert into payments table
        $stmt = $con->prepare("INSERT INTO payments (user_id, payment_type, status) VALUES (?, ?, 'pending')");
        $stmt->bind_param("is", $user_id, $payment_method);
        $stmt->execute();
        $payment_id = $stmt->insert_id; // Get payment ID

        // Insert into orders table
        $stmt = $con->prepare("INSERT INTO orders (user_id, name, shipping_address, billing_address, total_price, payment_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssdi", $user_id, $name, $shipping_address, $billing_address, $total, $payment_id);
        $stmt->execute();
        $order_id = $stmt->insert_id; // Get order ID

        // Insert each cart item into order_details
        foreach ($_SESSION['cart'] as $productID => $item) {
            $stmt = $con->prepare("INSERT INTO order_details (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisdi", $order_id, $productID, $item['title'], $item['price'], $item['quantity']);
            $stmt->execute();
        }

        // Clear cart & redirect
        $_SESSION['cart'] = [];
        $_SESSION['success_message'] = "Your order has been placed successfully!";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <script>
        function toggleCreditCardFields() {
            var paymentMethod = document.getElementById("payment").value;
            var creditCardFields = document.getElementById("credit-card-fields");
            if (paymentMethod === "credit_card") {
                creditCardFields.style.display = "block";
            } else {
                creditCardFields.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="logout.php">Log Out</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="user.php">My Profile</a></li>
            <li><a href="sell.php">Sell an Item</a></li>
        </ul>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
    </div>

    <h2 style="text-align: center; padding-right: 220px;">Checkout</h2>
    
    <div class="container">
        <div class="text">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <table style="width: 90%;">
                    <tr>
                        <td><label>Name</label></td>
                        <td><input type="text" name="name" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Shipping Address</label></td>
                        <td><textarea name="shipping_address" class="form-control"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Billing Address</label></td>
                        <td><textarea name="billing_address" class="form-control"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Payment Method</label></td>
                        <td>
                            <select name="payment" id="payment" class="form-control" onchange="toggleCreditCardFields()">
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <div id="credit-card-fields" style="display: none;">
                    <h4>Credit Card Details</h4>
                    <table style="width: 90%;">
                        <tr>
                            <td><label>Card Number</label></td>
                            <td><input type="text" name="card_number" class="form-control" maxlength="16"></td>
                        </tr>
                        <tr>
                            <td><label>Expiry Date</label></td>
                            <td><input type="text" name="expiry_date" class="form-control" placeholder="MM/YY"></td>
                        </tr>
                        <tr>
                            <td><label>CVV</label></td>
                            <td><input type="text" name="cvv" class="form-control" maxlength="3"></td>
                        </tr>
                    </table>
                </div>
                
                <br>
                <table style="width: 147%;">
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </table>
                
                <br><br>
                <div class="container">
                    <button type="submit" class="btn btn-primary btn-sm btn-block" style="width: 50%; margin-left: 300px;">Place Order</button>
                    <a href="cart.php" class="btn btn-secondary btn-sm btn-block" style="width: 50%; margin-left: 300px; margin-top: 10px;">Back to Cart</a>
                </div>
            </form>
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


