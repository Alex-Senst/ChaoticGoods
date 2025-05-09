<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['promote_id'])) {
        $id = $_POST['promote_id'];
        $stmt = $con->prepare("UPDATE users SET role = 'admin' WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif (isset($_POST['create_user'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $role = $_POST['role'];
        $stmt = $con->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        $stmt->execute();
    }
}

$users = $con->query("SELECT user_id, username, role FROM users ORDER BY created_at DESC");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT username, role FROM users WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['role'] !== 'admin') {
    echo "Access Denied";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php" class="active">Admin Dashboard</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
            </div>
        </div>

        <div class="content">
            <h2>Admin Dashboard</h2>
            <h3>Welcome, <?= htmlspecialchars($user['username']) ?>!</h3>

            <h3>Promote Users to Admin</h3>
            <table>
                <tr><th>Username</th><th>Role</th><th>Action</th></tr>
                <?php while ($u = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= $u['role'] ?></td>
                    <td>
                        <?php if ($u['role'] !== 'admin'): ?>
                        <form method="POST">
                            <input type="hidden" name="promote_id" value="<?= $u['user_id'] ?>">
                            <button type="submit">Promote to Admin</button>
                        </form>
                        <?php else: ?>Already Admin<?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>

            <h2>Add New User</h2>
            <form method="POST" style="max-width: 400px; margin: 5px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9;">
                <label for="username" style="display: block; margin-bottom: 5px;">Username</label>
                <input name="username" id="username" placeholder="Enter username" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

                <label for="email" style="display: block; margin-bottom: 5px;">Email</label>
                <input name="email" id="email" placeholder="Enter email" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

                <label for="password" style="display: block; margin-bottom: 5px;">Password</label>
                <input name="password" id="password" type="password" placeholder="Enter password" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

                <label for="role" style="display: block; margin-bottom: 5px;">Role</label>
                <select name="role" id="role" style="width: 100%; padding: 8px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>

                <button name="create_user" type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Create User
                </button>
            </form>
        </div>
    </div>
</body>
</html>
