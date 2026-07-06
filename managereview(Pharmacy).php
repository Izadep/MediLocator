<?php
include 'database.php';
include 'pharmacyauth.php';

$userId = $_SESSION['user_id'] ?? null;

if (isset($_GET['delete'])) {
   $reviewId = mysqli_real_escape_string($conn, $_GET['delete']);

    $check = mysqli_query($conn, "SELECT r.reviewId FROM review r
                                    INNER JOIN pharmacy c ON r.pharmacyId = c.pharmacyId
                                    WHERE r.reviewId = '$reviewId'
                                    AND c.userId = '$userId'
    ");

    if (mysqli_num_rows($check) == 0) {
        header("Location: managereview(Pharmacy).php?error=unauthorized");
        exit();
    }

    mysqli_query($conn, " DELETE FROM review
                            WHERE reviewId = '$reviewId'
    ");
}
        $pharmacyName = "";

        $pharmacyQuery = mysqli_query($conn, "
            SELECT pharmacyName 
            FROM pharmacy 
            WHERE userId = '$userId'
        ");

        if ($pharmacyQuery && mysqli_num_rows($pharmacyQuery) > 0) {
            $names = [];

            while ($row = mysqli_fetch_assoc($pharmacyQuery)) {
                $names[] = $row['pharmacyName'];
            }

            $pharmacyName = implode(", ", $names);
        } else {
            $pharmacyName = "No Pharmacy Found";
        }
$result = mysqli_query($conn, "SELECT r.*, c.pharmacyName, p.pharmacyName, u.name AS userName
                                FROM review r
                                INNER JOIN pharmacy c
                                    ON r.pharmacyId = c.pharmacyId
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
    <link rel="stylesheet" href="managereview(Pharmacy).css">
</head>
<body>
    <div class = container>
     <?php include("navbarpharmacy.php") ?>

    <div class="admin-content">
        <div class="admin-title">MediLocator Pharmacy Dashboard</div>
        <h1>Manage Review For <?php echo htmlspecialchars($pharmacyName); ?></h1>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
            <p style="color:green;">Review deleted successfully.</p>
        <?php endif; ?>


        <table class="admin-table">
            <tr>
                <th>Review ID</th>
                <th>Pharmacy Name</th>
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
                <?php echo isset($row['pharmacyName']) && $row['pharmacyName'] !== ''? htmlspecialchars($row['pharmacyName']): '-'; ?>
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
                        <a href="managereview(Pharmacy).php?delete=<?php echo urlencode($row['reviewId']); ?>"
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