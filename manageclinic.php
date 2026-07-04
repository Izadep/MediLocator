<?php
session_start();
include 'database.php';
include 'adminauth.php';


if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    // Check appointment records
    $checkAppointment = mysqli_query($conn, "
        SELECT COUNT(*) AS total 
        FROM appointment 
        WHERE clinicId = $id
    ");
    $appointmentData = mysqli_fetch_assoc($checkAppointment);

    // Check review records
    $checkReview = mysqli_query($conn, "
        SELECT COUNT(*) AS total 
        FROM review 
        WHERE clinicId = $id
    ");
    $reviewData = mysqli_fetch_assoc($checkReview);

    if ($appointmentData['total'] > 0 || $reviewData['total'] > 0) {
        header("Location: manageclinic.php?error=has_records");
        exit();
    }

    // Get clinic image
    $result = mysqli_query($conn, "
        SELECT clinicImage 
        FROM clinic 
        WHERE clinicId = $id
    ");
    $clinic = mysqli_fetch_assoc($result);

    // Delete clinic
    mysqli_query($conn, "
        DELETE FROM clinic 
        WHERE clinicId = $id
    ");

    // Delete image only after clinic is deleted
    if ($clinic && !empty($clinic['clinicImage'])) {
        $imagePath = $clinic['clinicImage'];

        // Only delete files inside image folder
        if (strpos($imagePath, 'image/') === 0 && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    header("Location: manageclinic.php?deleted=success");
    exit();
}

    $result = mysqli_query($conn, "SELECT * FROM clinic ORDER BY clinicId");

    $search = $_GET['search'] ?? '';
    $searchSafe = mysqli_real_escape_string($conn, $search);

    if ($searchSafe !== '') {
        $result = mysqli_query($conn, "
            SELECT *
            FROM clinic
            WHERE clinicName LIKE '%$searchSafe%'
            OR address LIKE '%$searchSafe%'
            OR phoneNum LIKE '%$searchSafe%'
            OR specialty LIKE '%$searchSafe%'
            ORDER BY clinicId
        ");
    } else {
        $result = mysqli_query($conn, "
            SELECT *
            FROM clinic
            ORDER BY clinicId
        ");
    }
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

        <?php 
        $placeholder = "Search clinic...";
        include 'searchadmin.php'; 
        ?>

        <a href="clinicform.php" class="btn-add">+ Add Clinic</a>


            <?php if (isset($_GET['error']) && $_GET['error'] == 'has_appointment'): ?>
                <p style="color:red;">This clinic cannot be deleted because they still have appointment records.</p>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'has_records'): ?>
                <p style="color:red;">
                    This clinic cannot be deleted because it still has appointment or review records.
                </p>
            <?php endif; ?>

            <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
                <p style="color:green;">Clinic deleted successfully.</p>
            <?php endif; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] == 'added'): ?>
                <p style="color:green;">Clinic added successfully.</p>
            <?php endif; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] == 'updated'): ?>
                <p style="color:green;">Clinic updated successfully.</p>
            <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0): ?>

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
        
        <?php else: ?>

        <div class="no-result-message">
            No clinic found<?php echo !empty($search) ? " for <strong>" . htmlspecialchars($search) . "</strong>" : ""; ?>.
        </div>
        <?php endif; ?>

    </div>
    </div>
    <?php include("footer.php") ?>
</body>
</html>