<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <!--<link rel="stylesheet" href="style.css"/>-->
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('https://www.dndspeak.com/wp-content/uploads/2021/06/Thrift-1.png');
            background-size: cover;
        }

        .glass-container {
            width: 300px;
            height: 350px;
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: 1px solid #fff;
        }

        .glass-container::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: -1;
        }

        .login-box {
            max-width: 250px;
            margin: 0 auto;
            text-align: center;
        }

        h2 {
            color: #fff;
            margin-top: 30px;
            margin-bottom: -20px;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        input {
            padding: 10px;
            margin-top: 25px;
            border: none;
            border-radius: 10px;
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            font-size: 13px;
        }

        input::placeholder {
            color: #fff;
            opacity: 0.5;
        }

        input:focus {
            outline: none;
        }

        .options {
            display: flex;
            align-items: center;
            margin-top: 15px;
            font-size: 12px;
            color: white;
        }

        .options input {
            margin-right: 5px;
            margin-top: 0px;
        }

        .options a {
            text-decoration: none;
            color: white;
            margin-left: auto;
        }

        button {
            background: #fff;
            color: black;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background: transparent;
            color: white;
            outline: 1px solid #fff;
        }

        p {
            font-size: 12px;
            color: #fff;
            margin-top: 15px;
        }

        #register {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        .login-link a{
            color: cornflowerblue;
        }
        .login-link a:hover{
            color: lightblue;
        }
        </style>
</head>
<body>
<?php
    require('db.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($con, $password);
        
        // Hash the password using MD5 before checking the database
        $hashed_password = md5($password);

        // Debugging: Show the hashed password to compare with the database
        // echo "MD5 Hash: " . $hashed_password; exit();

        // Check if the user exists
        $query = "SELECT * FROM `users` WHERE username='$username' AND password='$hashed_password'";
        $result = mysqli_query($con, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($con)); // Debugging database errors
        }

        $rows = mysqli_num_rows($result);

        if ($rows == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            if (isset($_SESSION['redirect_to_cart'])) {
                $productId = $_SESSION['redirect_to_cart']['product_id'];
                $quantity = $_SESSION['redirect_to_cart']['quantity'];
    
                // **Retrieve the product from database**
                $query = "SELECT * FROM `products` WHERE product_id='$productId'";
                $result = mysqli_query($con, $query);
    
                if ($result && mysqli_num_rows($result) > 0) {
                    $product = mysqli_fetch_assoc($result);
    
                    // **Use the working model**
                    $_SESSION['cart'][$productId] = [
                        'title' => $product['title'],
                        'price' => $product['price'],
                        'quantity' => $quantity
                    ];
                }
    
                // Clear session variable after adding to cart
                unset($_SESSION['redirect_to_cart']);
    
                // Redirect to the cart page
                header("Location: cart.php");
                exit();
            } else {
                if ($user['role'] === 'admin') {
                    header("Location: admin/dashboard.php"); // <-- Your admin dashboard
                } else {
                    header("Location: user.php");
                }
                exit();
            }
            // Redirect to user dashboard page
            //header("Location: user.php");
            //exit(); // Ensure script stops here
        } else {
            echo "<script>
                alert('Incorrect Username or Password.');
                window.location.href = 'login.php';
            </script>";
            exit();            
        }

    } else{
?>
    <div class="glass-container">
        <div class="login-box">
            <h2>Login</h2>
            <form method="POST" autocomplete="off">
                <input type="text" class="login-input" name="username" placeholder="username" required />
                <input type="password" class="login-input" name="password" placeholder="Password" required />
                <input type="submit" value="Login" class="login-button" />
            </form>
            <p class="login-link"><a href="registration.php">Don't have an account yet? Register here!</a></p>
            <p class="login-link"><a href="index.php">Return to Homepage</a></p>
        </div>
    </div>
<?php
    }
?>
</body>
</html>