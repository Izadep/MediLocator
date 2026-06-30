<?php
session_start();
include 'database.php';

// Handle delete
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
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav class="admin-nav">
        <div class="admin-nav-title">MediLocator Admin</div>
        <div class="admin-nav-links">
            <a href="AdminDashboard.php">Dashboard</a>
            <a href="manageusers.php" class="active">Users</a>
            <a href="manageclinic.php">Clinics</a>
            <a href="manage_pharmacy.php">Pharmacies</a>
            <a href="manage_appointment.php">Appointments</a>
            <a href="admin_logout.php" style="color:#ffb3b3;">Log out</a>
        </div>
    </nav>

    <div class="admin-content">
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
</body>
</html>