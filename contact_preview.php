
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
            .container {
                max-width: 600px;
                margin-top: 50px;
                margin-left: 350px;
            }
        </style>
    </head>
    <!--Navigation Menu-->
    <body>
        <div class="sidebar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="login.php">Sign In</a></li>
                <li><a href="registration.php">Sign Up</a></li>
            </ul>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
            </div>
        </div>
        <div class="container">
            <h2 class="text-center">Contact</h2>
            <form>
                <div class="mb-3 mt-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="4" placeholder="Your message"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
        <footer>
            <p>ChaoticGoods</p>
            <p><a href="about_preview.php">About</a></p>
            <p><a href="contact_preview.php" class="active">Contact</a></p>
            <p><a href="cookies_preview.php">Cookies</a></p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
