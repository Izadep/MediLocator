<?php
session_start();
include 'database.php';

if (isset($_GET['delete'])) {
    $userId = mysqli_real_escape_string($conn, $_GET['delete']);

    if ($userId === $_SESSION['user_id']) {
        // Don't let an admin delete their own account
        header("Location: manageusers.php?error=self");
        exit();
    }

    mysqli_query($conn, "DELETE FROM users WHERE userId = '$userId'");
    header("Location: manageusers.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM users ORDER BY userId");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="adminMain.css">
    <link rel="stylesheet" href="manageusers.css">
</head>
<body>
    <div class = container>
     <?php include("navbaradmin.php") ?>

    <div class="admin-content">
        <div class="admin-title">MediLocator Admin</div>
        <h1>Manage Users</h1>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'self'): ?>
            <p style="color:red;">You can't delete your own admin account while logged in.</p>
        <?php endif; ?>

        <table class="admin-table">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['userId']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
                <td>
                    <a href="manageusers.php?delete=<?php echo urlencode($row['userId']); ?>"
                       class="btn-delete"
                       onclick="return confirm('Delete this user? This cannot be undone.');">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    </div>
    <?php include("footer.php") ?>
</body>
</html>