<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .container {
            margin-right: 220px;
            padding: 20px;
            flex-grow: 1;
        }
        .row img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
    <!-- Navigation Menu -->
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

        <div class="container">
            <!-- About Us Section -->
            <h2 class="text-center my-4">About Us</h2>

            <!-- Images and Blurb -->
            <div class="row text-center mb-4">
                <div class="col-md-6">
                    <img src="Shan.jpg" alt="Shan" class="img-fluid rounded mb-3">
                    <p>Our team is passionate about providing the best products for your needs. We believe in quality and innovation.</p>
                </div>
                <div class="col-md-6">
                    <img src="Alex.jpg" alt="Alex" class="img-fluid rounded mb-3">
                    <p>We are committed to customer satisfaction and always strive to exceed your expectations with every purchase.</p>
                </div>
                <p> Hello there, we are a small business... </p>
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
