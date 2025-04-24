<?php
require 'admin_auth.php';

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
?>

<h2>Promote Users to Admin</h2>
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
<form method="POST">
    <input name="username" placeholder="Username"><br>
    <input name="email" placeholder="Email"><br>
    <input name="password" type="password" placeholder="Password"><br>
    <select name="role">
        <option value="buyer">Buyer</option>
        <option value="seller">Seller</option>
        <option value="admin">Admin</option>
    </select><br>
    <button name="create_user" type="submit">Create User</button>
</form>
