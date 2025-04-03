<?php
session_start();
require 'db.php';

// Initialize user session
$user_id = isset($_SESSION['user-id']) ? $_SESSION['user-id'] : 0;

// Fetch products from the correct database
$products = [];
$result = $con->query("SELECT product_id, title, price FROM products");
while ($row = $result->fetch_assoc()) {
    $products[$row['product_id']] = $row;
}

// Initialize cart for user
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If the user is not logged in, store the item data in session and redirect to login
if (!isset($_SESSION['user-id'])) {
    // Store the product and quantity to session for later use
    if(isset($_POST['add'])){
            $_SESSION['redirect_to_cart'] = [
                'product_id' => $_POST['add'],
                'quantity' => 1
            ];
    }


    // Redirect to login page
    header("Location: login.php");
    exit();
}


//Add products to cart
if (isset($_POST['add'])) {
    
    $productId = $_POST['add'];
    $quantity = isset($_POST['quantity'][$productId]) ? $_POST['quantity'][$productId] : 1;

    if (isset($products[$productId])) {
        $_SESSION['cart'][$productId] = [
            'title' => $products[$productId]['title'],
            'price' => $products[$productId]['price'],
            'quantity' => $quantity
        ];
    }
}

// Remove products
if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    unset($_SESSION['cart'][$productId]);
}

// Calculate total
$total = 0;
$totalItems = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
    $totalItems += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="logout.php">Log Out</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php" class="active">Cart</a></li>
            <li><a href="user.php">My Profile</a></li>
            <li><a href="sell.php">Sell an Item</a></li>

        </ul>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
    </div>
    <h2 style="text-align: center; padding-right: 220px; padding-top: 15px;">My Cart</h2>
    <div class="container">
        <div class="text">
            <?php if (empty($_SESSION['cart'])): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <table style="width: 110%;">
                    <tr>
                        <th>Product</th>
                        <th>Each</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($_SESSION['cart'] as $productId => $item): ?>
                        <tr>
                            <td><a href="details.php?id=<?php echo $productId; ?>"> <?php echo $item['title']; ?> </a></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td><a href="?remove=<?php echo $productId; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>
                <table style="width: 100%; margin-top: 20px;">
                    <tr>
                        <td style="text-align: left;"># Items: <?php echo $totalItems; ?></td>
                        <td style="text-align: right; font-weight: bold;">Total: $<?php echo number_format($total, 2); ?></td>
                    </tr>
                </table>
                <br><br>
                <div class="container">
                    <a href="checkout.php" class="btn btn-primary btn-sm btn-block" style="width: 50%; margin-left: 350px;">Checkout</a>
                </div>
            <?php endif; ?>
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


