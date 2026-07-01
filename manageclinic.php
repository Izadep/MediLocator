<?php
session_start();
include 'database.php';
include 'adminauth.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM clinic WHERE clinicId = $id");
    header("Location: manageclinic.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM clinic ORDER BY clinicId");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Clinics</title>
    <link rel="stylesheet" href="adminMain.css">
    <link rel="stylesheet" href="manageclinic.css">
</head>
<body>
    <div class = container>
     <?php include("navbaradmin.php") ?>

    <div class="admin-content">
        <div class="admin-title">MediLocator Admin</div>
            <h1>Manage Clinics</h1> 
            <a href="clinicform.php" class="btn-add">+ Add Clinic</a>
        
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
                <td><?php echo $row['clinicId']; ?></td>
                <td><?php echo htmlspecialchars($row['clinicName']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><?php echo htmlspecialchars($row['phoneNum']); ?></td>
                <td>
                    <a href="clinicform.php?id=<?php echo $row['clinicId']; ?>" class="btn-edit">Edit</a>
                    <a href="manageclinic.php?delete=<?php echo $row['clinicId']; ?>"
                       class="btn-delete"
                       onclick="return confirm('Delete this clinic?');">
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