<?php
include 'database.php';
include 'clinicauth.php';

$userId = $_SESSION['user_id'] ?? null;

if (isset($_GET['delete'])) {
   $reviewId = mysqli_real_escape_string($conn, $_GET['delete']);

    $check = mysqli_query($conn, "SELECT r.reviewId FROM review r
                                    INNER JOIN clinic c ON r.clinicId = c.clinicId
                                    WHERE r.reviewId = '$reviewId'
                                    AND c.userId = '$userId'
    ");

    if (mysqli_num_rows($check) == 0) {
        header("Location: managereview(Clinic).php?error=unauthorized");
        exit();
    }

    mysqli_query($conn, " DELETE FROM review
                            WHERE reviewId = '$reviewId'
    ");
}
        $clinicName = "";

        $clinicQuery = mysqli_query($conn, "
            SELECT clinicName 
            FROM clinic 
            WHERE userId = '$userId'
        ");

        if ($clinicQuery && mysqli_num_rows($clinicQuery) > 0) {
            $names = [];

            while ($row = mysqli_fetch_assoc($clinicQuery)) {
                $names[] = $row['clinicName'];
            }

            $clinicName = implode(", ", $names);
        } else {
            $clinicName = "No Clinic Found";
        }

        if ($row = mysqli_fetch_assoc($clinicQuery)) {
            if (!empty($row['clinicName'])) {
                $clinicName = $row['clinicName'];
            }
        }
$result = mysqli_query($conn, "SELECT r.*, c.clinicName, p.pharmacyName, u.name AS userName
                                FROM review r
                                INNER JOIN clinic c
                                    ON r.clinicId = c.clinicId
                                LEFT JOIN pharmacy p
                                    ON r.pharmacyId = p.pharmacyId
                                LEFT JOIN users u
                                    ON r.userId = u.userId
                                WHERE c.userId = '$userId'
                                ORDER BY r.reviewId
                            ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Review</title>
    <link rel="stylesheet" href="managereview(Clinic).css">
</head>
<body>
    <div class = container>
     <?php include("navbarclinic.php") ?>

    <div class="admin-content">
        <div class="admin-title">MediLocator Clinic Dashboard</div>
        <h1>Manage Review For <?php echo htmlspecialchars($clinicName); ?></h1>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
            <p style="color:green;">Review deleted successfully.</p>
        <?php endif; ?>


        <table class="admin-table">
            <tr>
                <th>Review ID</th>
                <th>Clinic Name</th>
                <th>Pharmacy Name</th>
                <th>Username</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['reviewId']); ?></td>
                <td>
                <?php echo isset($row['clinicName']) && $row['clinicName'] !== ''? htmlspecialchars($row['clinicName']): '-'; ?>
                </td>
                <td>
                <?php echo isset($row['pharmacyName']) && $row['pharmacyName'] !== ''? htmlspecialchars($row['pharmacyName']): '-'; ?>
                </td>
                <td><?php echo htmlspecialchars($row['userName']); ?></td>
                <td><?php echo htmlspecialchars($row['comments']); ?></td>
                <td><?php echo htmlspecialchars($row['reviewDate']); ?></td>
                <td><?php echo htmlspecialchars($row['rating']); ?></td>
                <?php if ($row['userId'] != 'USR001') { ?>
                    <td>
                        <a href="managereview(Clinic).php?delete=<?php echo urlencode($row['reviewId']); ?>"
                        class="btn-delete"
                        onclick="return confirm('Delete this review? This cannot be undone.');">
                        Delete
                        </a>
                    </td>
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