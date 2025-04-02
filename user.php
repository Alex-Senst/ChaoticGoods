<?php
    session_start();
    if(!isset($_SESSION['user-id'])){
        header("Location: login.php");
        exit();
    }
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
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <div class="sidebar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="user.php" class="active">My Profile</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
    </div>
    <!--User Profile-->
    <div class="container">
        <h2>Profile Information</h2>
            <div class="text">
                <p>Username:</p>
                <p>Email: </p>
                <p>Shipping Address: </p>
                <p>Billing Address: </p>
                <a href="changeps.html">Change Password</a></li>
            </div>
    </div>
    <div class="container">
        <h2>Order History</h2>
        <div class="text">
            <table style="width: 100%;">
                <tr>
                    <td>Date 1</td>
                    <td>Product 1</td>
                    <td>Status 1</td>
                    <td>
                        <a href="reorder.html">Reorder</a>
                    </td>
                </tr>
                <tr>
                    <td>Date 2</td>
                    <td>Product 2</td>
                    <td>Status 2</td>
                    <td>
                        <a href="reorder.html">Reorder</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
