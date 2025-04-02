<?php
session_start();
if (!isset($_SESSION['user-id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php'; // Database connection

$user_id = $_SESSION['user-id'];

// Fetch current user data
$query = "SELECT username, email, shipping_address, billing_address FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_shipping = trim($_POST['shipping_address']);
    $new_billing = trim($_POST['billing_address']);

    $update_query = "UPDATE users SET username=?, email=?, shipping_address=?, billing_address=? WHERE id=?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $new_username, $new_email, $new_shipping, $new_billing, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['username'] = $new_username;
        header("Location: user.php?success=Profile Updated Successfully");
        exit();
    } else {
        $error = "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Edit Profile</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card p-4">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Shipping Address:</label>
                    <input type="text" name="shipping_address" class="form-control" value="<?php echo htmlspecialchars($user['shipping_address']); ?>">
                </div>
                <div class="form-group">
                    <label>Billing Address:</label>
                    <input type="text" name="billing_address" class="form-control" value="<?php echo htmlspecialchars($user['billing_address']); ?>">
                </div>
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="user.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
