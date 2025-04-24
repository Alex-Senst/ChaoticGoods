<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php'; // Include database connection

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT username, email FROM users WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch order history
//$order_query = "SELECT order_date, status FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$order_query = "
    SELECT order_id, order_date, status 
    FROM orders 
    WHERE user_id = ? 
    ORDER BY order_date DESC";
$order_stmt = $con->prepare($order_query);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body h1 {
            margin-left: 10px;
            margin-top: 15px;
            font-family: 'Papyrus', fantasy;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
    
    <div class="sidebar">
        <ul>
            <li><a href="logout.php">Log Out</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="user.php" class="active">My Profile</a></li>
            <li><a href="sell.php">Sell an Item</a></li>

        </ul>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
    </div>

    <!-- User Profile -->
    <div class="container">
        <h2>Profile Information</h2>
        <div class="text">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <a href="changeps.php">Change Password</a>
            <a href="edit_profile.php" class="btn btn-warning btn-sm">Edit Profile</a>
        </div>
    </div>

    <!-- Order History -->
    <div class="container">
        <h2>Order History</h2>
        <div class="text">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $order_result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <a href="order_details.php?order_id=<?php echo urlencode($order['order_id']); ?>">
                                    #<?php echo htmlspecialchars($order['order_id']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td>
                            <a href="reorder.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-primary btn-sm">Reorder</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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
