<?php
include 'adminauth.php';
include 'database.php';

if (isset($_GET['delete'])) {
    $reviewId = mysqli_real_escape_string($conn, $_GET['delete']);
    $currentUserId = $_SESSION['reveiewId'] ?? '';

    mysqli_query($conn, "DELETE FROM review WHERE reviewId = '$reviewId'");
    header("Location: managereview.php?deleted=success");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM review ORDER BY reviewId");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Review</title>
    <link rel="stylesheet" href="adminMain.css">
    <link rel="stylesheet" href="manageusers.css">
</head>
<body>
    <div class = container>
     <?php include("navbaradmin.php") ?>

    <div class="admin-content">
        <div class="admin-title">MediLocator Admin</div>
        <h1>Manage Review</h1>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
            <p style="color:green;">User deleted successfully.</p>
        <?php endif; ?>


        <table class="admin-table">
            <tr>
                <th>Review ID</th>
                <th>Clinic ID</th>
                <th>Pharmacy ID</th>
                <th>User ID</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['reviewId']); ?></td>
                <td>
                <?php echo isset($row['clinicId']) && $row['clinicId'] !== ''? htmlspecialchars($row['clinicId']): '-'; ?>
                </td>
                <td>
                <?php echo isset($row['pharmacyId']) && $row['pharmacyId'] !== ''? htmlspecialchars($row['pharmacyId']): '-'; ?>
                </td>
                <td><?php echo htmlspecialchars($row['userId']); ?></td>
                <td><?php echo htmlspecialchars($row['comments']); ?></td>
                <td><?php echo htmlspecialchars($row['reviewDate']); ?></td>
                <?php if ($row['userId'] != 'USR001') { ?>
                    <td>
                    <a href="managereview.php?delete=<?php echo urlencode($row['reviewId']); ?>"
                       class="btn-delete"
                       onclick="return confirm('Delete this user? This cannot be undone.');">
                       Delete
                    </a>
                </td>
                <?php } ?>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    </div>
    <?php include("footer.php") ?>
</body>
</html>