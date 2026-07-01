<?php
session_start();
include 'database.php';
include 'adminauth.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $result = mysqli_query($conn, "SELECT pharmacyImage FROM pharmacy WHERE pharmacyId = $id");
    $pharmacy = mysqli_fetch_assoc($result);

    if ($pharmacy && !empty($pharmacy['pharmacyImage'])) {
        $imagePath = $pharmacy['pharmacyImage'];

        // Only delete files inside image folder
        if (strpos($imagePath, 'image/') === 0 && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }


    mysqli_query($conn, "DELETE FROM pharmacy WHERE pharmacyId = $id");

    header("Location: managepharmacy.php");
    exit();

}

$result = mysqli_query($conn, "SELECT * FROM pharmacy ORDER BY pharmacyId");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pharmacies</title>
    <link rel="stylesheet" href="adminMain.css">
    <link rel="stylesheet" href="manageclinic.css">
</head>
<body>
     <div class = container>
     <?php include("navbaradmin.php") ?>

    <div class="admin-content">
        <div class="admin-title">MediLocator Admin</div>
            <h1>Manage Pharmacies</h1>
            <a href="pharmacyform.php" class="btn-add">+ Add Pharmacy</a>
        

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
    </div>
      <?php include("footer.php") ?>
</body>
</html>