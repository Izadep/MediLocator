<?php
session_start();
include 'database.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM pharmacy WHERE pharmacyId = $id");
    header("Location: managepharmacy.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM pharmacy ORDER BY pharmacyName");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pharmacies</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav class="admin-nav">
        <div class="admin-nav-title">MediLocator Admin</div>
        <div class="admin-nav-links">
            <a href="admindashboard.php">Dashboard</a>
            <a href="manageusers.php">Users</a>
            <a href="manageclinic.php">Clinics</a>
            <a href="managepharmacy.php" class="active">Pharmacies</a>
            <a href="manageappointment.php">Appointments</a>
            <a href="adminlogout.php" style="color:#ffb3b3;">Log out</a>
        </div>
    </nav>

    <div class="admin-content">
        <div class="content-header">
            <h1>Manage Pharmacies</h1>
            <a href="pharmacyform.php" class="btn-add">+ Add Pharmacy</a>
        </div>

        <table class="admin-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['pharmacyId']; ?></td>
                <td><?php echo htmlspecialchars($row['pharmacyName']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><?php echo htmlspecialchars($row['phoneNum']); ?></td>
                <td>
                    <a href="pharmacyform.php?id=<?php echo $row['pharmacyId']; ?>" class="btn-edit">Edit</a>
                    <a href="managepharmacy.php?delete=<?php echo $row['pharmacyId']; ?>"
                       class="btn-delete"
                       onclick="return confirm('Delete this pharmacy?');">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>