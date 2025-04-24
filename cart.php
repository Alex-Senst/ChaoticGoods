<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'] ?? 0;

// Fetch products
$products = [];
$result = $con->query("SELECT product_id, title, price FROM products");
while ($row = $result->fetch_assoc()) {
    $products[$row['product_id']] = $row;
}

// If not logged in, use session and redirect
if (!$user_id) {
    if (isset($_POST['add'])) {
        $_SESSION['redirect_to_cart'] = [
            'product_id' => $_POST['add'],
            'quantity' => 1
        ];
    }
    header("Location: login.php");
    exit();
}

// ADD item to cart
if (isset($_POST['add'])) {
    $productId = $_POST['add'];
    $quantity = 1;
    $stmt = $con->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)
                           ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    $stmt->bind_param("iiii", $user_id, $productId, $quantity, $quantity);
    $stmt->execute();
}

// UPDATE quantities
if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        $stmt = $con->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $productId);
        $stmt->execute();
    }
}

// REMOVE item
if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    $stmt = $con->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $productId);
    $stmt->execute();
}

// LOAD CART from DB
$cart = [];
$total = 0;
$totalItems = 0;
$stmt = $con->prepare("SELECT product_id, quantity FROM cart_items WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $productId = $row['product_id'];
    if (isset($products[$productId])) {
        $cart[$productId] = [
            'title' => $products[$productId]['title'],
            'price' => $products[$productId]['price'],
            'quantity' => $row['quantity']
        ];
        $total += $products[$productId]['price'] * $row['quantity'];
        $totalItems += $row['quantity'];
    }
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
            <?php if (empty($cart)): ?>
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
                    <?php foreach ($cart as $productId => $item): ?>
                        <tr>
                            <td><a href="details.php?id=<?php echo $productId; ?>"> <?php echo $item['title']; ?> </a></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form action="cart.php" method="POST">
                                    <select name="quantity[<?php echo $productId; ?>]" onchange="this.form.submit()">
                                        <?php for ($i = 1; $i <= 15; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php echo $i == $item['quantity'] ? 'selected' : ''; ?>>
                                                <?php echo $i; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </form>
                            </td>
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


