<?php
session_start();
include 'database.php';
include 'adminauth.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $result = mysqli_query($conn, "SELECT clinicImage FROM clinic WHERE clinicId = $id");
    $clinic = mysqli_fetch_assoc($result);

    if ($clinic && !empty($clinic['clinicImage'])) {
        $imagePath = $clinic['clinicImage'];

        // Only delete files inside image folder
        if (strpos($imagePath, 'image/') === 0 && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    
    $check = mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointment WHERE clinicId = '$id'");
    $data = mysqli_fetch_assoc($check);

    if ($data['total'] > 0) {
        header("Location: manageclinic.php?error=has_appointment");
        exit();
    }

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

            <?php if (isset($_GET['error']) && $_GET['error'] == 'has_appointment'): ?>
                <p style="color:red;">This clinic cannot be deleted because they still have appointment records.</p>
            <?php endif; ?>
        
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