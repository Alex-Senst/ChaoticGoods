<?php
$products = [
    ["id" => 1, "name" => "Product 1", "price" => 19.99],
    ["id" => 2, "name" => "Product 2", "price" => 24.99],
    ["id" => 3, "name" => "Product 3", "price" => 15.99]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="sidebar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php" class="active">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="user.php">My Profile</a></li>
            <li><a href="login.php">Sign In</a></li>
        </ul>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
    </div>

    <div class="container mt-4">
        <h1 class="text-center"><u>Products</u></h1>
        <form action="cart.php" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Add to Cart</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><a href="details.php?id=<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></a></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><input type="number" name="quantity[<?= $product['id'] ?>]" min="1" value="1"></td>
                            <td><button type="submit" name="add" value="<?= $product['id'] ?>" class="btn btn-primary">Add</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

