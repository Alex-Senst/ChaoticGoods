<?php
session_start();

// Redirect to profile after 3 seconds
header("refresh:3;url=user.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Successful</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { text-align: center; padding-top: 50px; }
    </style>
</head>
<body>
    <h2>Order Placed Successfully!</h2>
    <p>Redirecting to your profile page...</p>
</body>
</html>
