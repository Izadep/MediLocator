<?php
session_start();
include 'database.php';
include 'adminauth.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    // Check if pharmacy has reviews
    $check = mysqli_query($conn, "SELECT COUNT(*) AS total FROM review WHERE pharmacyId = $id");
    $data = mysqli_fetch_assoc($check);

    if ($data['total'] > 0) {
        header("Location: managepharmacy.php?error=has_review");
        exit();
    }

    // Get image
    $result = mysqli_query($conn, "SELECT pharmacyImage FROM pharmacy WHERE pharmacyId = $id");
    $pharmacy = mysqli_fetch_assoc($result);

    if ($pharmacy && !empty($pharmacy['pharmacyImage'])) {
        $imagePath = $pharmacy['pharmacyImage'];

        if (strpos($imagePath, 'image/') === 0 && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete pharmacy
    mysqli_query($conn, "DELETE FROM pharmacy WHERE pharmacyId = $id");

    header("Location: managepharmacy.php?deleted=success");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM pharmacy ORDER BY pharmacyId");

$search = $_GET['search'] ?? '';
$searchSafe = mysqli_real_escape_string($conn, $search);

if ($searchSafe !== '') {
    $result = mysqli_query($conn, "
        SELECT *
        FROM pharmacy
        WHERE pharmacyName LIKE '%$searchSafe%'
           OR address LIKE '%$searchSafe%'
           OR phoneNum LIKE '%$searchSafe%'
        ORDER BY pharmacyId
    ");
} else {
    $result = mysqli_query($conn, "
        SELECT *
        FROM pharmacy
        ORDER BY pharmacyId
    ");
}

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

            <?php
            $placeholder = "Search pharmacy...";
            include 'searchadmin.php';
            ?>
            
            <a href="pharmacyform.php" class="btn-add">+ Add Pharmacy</a>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'has_review'): ?>
            <p style="color:red;">This pharmacy cannot be deleted because it has review records.</p>
        <?php endif; ?>
        
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
            <p style="color:green;">Pharmacy deleted successfully.</p>  
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'added'): ?>
                <p style="color:green;">Pharmacy added successfully.</p>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'updated'): ?>
                <p style="color:green;">Pharmacy updated successfully.</p>
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

        <?php else: ?>

        <div class="no-result-message">
            No pharmacy found<?php echo !empty($search) ? " for <strong>" . htmlspecialchars($search) . "</strong>" : ""; ?>.
        </div>
        <?php endif; ?>
    </div>
      <?php include("footer.php") ?>
</body>
</html>