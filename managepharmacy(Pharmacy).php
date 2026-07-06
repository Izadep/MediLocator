<?php
session_start();
include 'database.php';
include 'pharmacyauth.php';

$userId = $_SESSION['user_id'] ?? null;

    if (isset($_GET['delete'])) {

        $id = (int) $_GET['delete'];

        // CHECK OWNERSHIP FIRST
        $checkOwner = mysqli_query($conn, "
            SELECT pharmacyId 
            FROM pharmacy 
            WHERE pharmacyId = $id 
            AND userId = '$userId'
        ");

        if (mysqli_num_rows($checkOwner) == 0) {
            header("Location: managepharmacy(Pharmacy).php?error=unauthorized");
            exit();
        }

        // Check review records
        $checkReview = mysqli_query($conn, "
            SELECT COUNT(*) AS total 
            FROM review 
            WHERE pharmacyId = $id
        ");
        $reviewData = mysqli_fetch_assoc($checkReview);

        if ($appointmentData['total'] > 0 || $reviewData['total'] > 0) {
            header("Location: managepharmacy(Pharmacy).php?error=has_records");
            exit();
        }

        // Get pharmacy image
        $result = mysqli_query($conn, "
            SELECT pharmacyImage 
            FROM pharmacy 
            WHERE pharmacyId = $id
        ");
        $pharmacy = mysqli_fetch_assoc($result);

        // Delete pharmacy
        mysqli_query($conn, "
            DELETE FROM pharmacy 
            WHERE pharmacyId = $id 
            AND userId = '$userId'
        ");

        // Delete image
        if ($pharmacy && !empty($pharmacy['pharmacyImage'])) {
            $imagePath = $pharmacy['pharmacyImage'];

            if (strpos($imagePath, 'image/') === 0 && file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        header("Location: managepharmacy(Pharmacy).php?deleted=success");
        exit();
    }

    // ================= SEARCH + LIST (ONLY USER'S DATA) =================

    $search = $_GET['search'] ?? '';
    $searchSafe = mysqli_real_escape_string($conn, $search);

    if ($searchSafe !== '') {
        $result = mysqli_query($conn, "
            SELECT *
            FROM pharmacy
            WHERE 
                pharmacyName LIKE '%$searchSafe%'
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
    <title>Manage Pharmacys</title>
    <link rel="stylesheet" href="managepharmacy(Pharmacy).css">
</head>
<body>
    <div class = container>
     <?php include("navbarpharmacy.php") ?>

    <div class="admin-content">
        <div class="admin-title">MediLocator Pharmacy Dashboard</div>
        <h1>Manage Pharmacies</h1>

        <?php 
        $placeholder = "Search pharmacy...";
        include 'searchadmin.php'; 
        ?>

        <a href="pharmacyform(Pharmacy).php" class="btn-add">+ Add Pharmacy</a>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'has_records'): ?>
                <p style="color:red;">
                    This pharmacy cannot be deleted because it still has review records.
                </p>
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
                    <?php if ($row['userId'] == $_SESSION['user_id']): ?>
                        <a href="pharmacyform(Pharmacy).php?id=<?php echo $row['pharmacyId']; ?>" class="btn-edit">Edit</a>

                        <a href="managepharmacy(Pharmacy).php?delete=<?php echo $row['pharmacyId']; ?>"
                        class="btn-delete"
                        onclick="return confirm('Delete this pharmacy?');">
                        Delete
                        </a>
                    <?php endif; ?>
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
    </div>
    <?php include("footer.php") ?>
</body>
</html>