<?php
session_start();
include 'database.php';
include 'adminauth.php';

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);

    mysqli_query($conn, "DELETE FROM appointment WHERE appointmentId = '$id'");

    header("Location: manageappointment.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM appointment ORDER BY dateTime DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="adminMain.css">
    <link rel="stylesheet" href="manageclinic.css">
</head>
<body>
    <div class="container">
        <?php include("navbaradmin.php") ?>

        <div class="admin-content">
            <div class="admin-title">MediLocator Admin</div>
            <h1>Manage Appointments</h1>

            <table class="admin-table">
                <tr>
                    <th>Appointment ID</th>
                    <th>Date & Time</th>
                    <th>User ID</th>
                    <th>Clinic ID</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['appointmentId']); ?></td>
                    <td><?php echo htmlspecialchars($row['dateTime']); ?></td>
                    <td><?php echo htmlspecialchars($row['userId']); ?></td>
                    <td><?php echo htmlspecialchars($row['clinicId']); ?></td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td>
                    <td>
                        <a href="manageappointment.php?delete=<?php echo urlencode($row['appointmentId']); ?>"
                           class="btn-delete"
                           onclick="return confirm('Delete this appointment?');">
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