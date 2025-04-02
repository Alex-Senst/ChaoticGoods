<?php
session_start();
require 'db.php'; // This file should contain the database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'] ?? ''; // Assuming the user is logged in
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($current_password) || empty($new_password) || empty($confirm_password)) {
        die("All fields are required.");
    }

    if ($new_password !== $confirm_password) {
        die("New passwords do not match.");
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=chaotic_goods", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the current password from the database
        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || md5($current_password) !== $user['password']) {
            die("Incorrect current password.");
        }

        // Hash the new password
        $hashed_password = md5($new_password);

        // Update password in database
        $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
        if ($update_stmt->execute([$hashed_password, $username])) {
            echo "Password successfully updated.";
        } else {
            echo "Error updating password.";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Change Password</title>
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('https://www.tribality.com/wp-content/uploads/2014/10/green-dragon-battle1.jpg');
            background-size: cover;
        }
        .glass-container {
            width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            border: 1px solid white;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            text-align: center;
        }
        h1 {
            color: white;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 10px;
            background: transparent;
            border: 1px solid white;
            color: white;
            font-size: 13px;
        }
        input::placeholder {
            color: white;
            opacity: 0.5;
        }
        input:focus {
            outline: none;
        }
        button {
            background: white;
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
    </style>
</head>
<body>
    <div class="glass-container">
        <h1>Change Password</h1>
        <form method="post">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>
