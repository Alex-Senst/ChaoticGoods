<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <!--<link rel="stylesheet" href="style.css"/>-->
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        a {
            font-size: 14px;
        }

        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('https://cdna.artstation.com/p/assets/images/images/003/292/706/large/olga-ok-.jpg?1472079911');
            background-size: cover;
        }

        .glass-container {
            width: 600px;
            height: 500px;
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: 1px solid black;
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

        .register-box {
            max-width: 450px;
            margin: 0 auto;
            text-align: left;
        }

        h1 {
            color: black;
            margin-top: 30px;
            margin-bottom: -20px;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-top: 30px;
        }

        input {
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            background: transparent;
            border: 1px solid black;
            color: black;
            font-size: 13px;
        }

        input::placeholder {
            color: black;
            opacity: 0.5;
        }

        input:focus {
            outline: none;
        }

        .options {
            display: flex;
            align-items: left;
            margin-top: 15px;
            font-size: 12px;
            color: black;
        }

        .options input {
            margin-right: 5px;
            margin-top: 0px;
        }

        .options a {
            text-decoration: none;
            color: black;
            margin-left: auto;
        }

        button {
            background: black;
            color: black;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background: transparent;
            color: black;
            outline: 1px solid #fff;
        }

        p {
            font-size: 12px;
            color: #fff;
            margin-top: 15px;
        }

        #register {
            text-decoration: none;
            color: black;
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
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        $first_name = stripslashes($_REQUEST['first_name']);
        $first_name = mysqli_real_escape_string($con, $first_name);
        $last_name = stripslashes($_REQUEST['last_name']);
        $last_name = mysqli_real_escape_string($con, $last_name);        
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);

        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $created_at = date("Y-m-d H:i:s");
        $query    = "INSERT into `users` (first_name, last_name, username, password, email, created_at)
                     VALUES ('$first_name', '$last_name', '$username', '" . md5($password) . "', '$email', '$created_at')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } else {
?>
    <div class="glass-container">
        <div class="register-box">
            <h1> Register Now! </h1>
            <form class="form" action="" method="post">
                <input type="text" class="login-input" name="first_name" placeholder="First Name" required />
                <input type="text" class="login-input" name="last_name" placeholder="Last Name" required />
                <input type="text" class="login-input" name="username" placeholder="Username" required />
                <input type="text" class="login-input" name="email" placeholder="Email Adress">
                <input type="password" class="login-input" name="password" placeholder="Password">
                <input type="submit" name="submit" value="Register" class="login-button">
                <p class="login-link"><a href="login.php">Already have an account? Login here!</a></p>
            </form>
        </div>
    </div>
<?php
    }
?>
</body>
</html>