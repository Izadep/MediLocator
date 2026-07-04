<?php
session_start();
include 'database.php';
include 'adminauth.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $check = mysqli_query($conn, "
        SELECT dateTime 
        FROM appointment 
        WHERE appointmentId = $id
    ");

    $appointment = mysqli_fetch_assoc($check);

    if (!$appointment) {
        header("Location: manageappointment.php?error=not_found");
        exit();
    }

    if (strtotime($appointment['dateTime']) > time()) {
        header("Location: manageappointment.php?error=future_appointment");
        exit();
    }

    mysqli_query($conn, "
        DELETE FROM appointment 
        WHERE appointmentId = $id
    ");

    header("Location: manageappointment.php?success=deleted");
    exit();
}

        $result = mysqli_query($conn, "
            SELECT 
                a.appointmentId,
                a.dateTime,
                u.name,
                c.clinicName,
                a.type
            FROM appointment a
            INNER JOIN users u
                ON a.userId = u.userId
            INNER JOIN clinic c
                ON a.clinicId = c.clinicId
            ORDER BY a.dateTime DESC
        ");
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

            <?php if (isset($_GET['error']) && $_GET['error'] == 'future_appointment'): ?>
                <p style="color:red;">
                    Upcoming appointments cannot be deleted.
                </p>
            <?php endif; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
                <p style="color:green;">
                    Appointment deleted successfully.
                </p>
            <?php endif; ?>

            <table class="admin-table">
                <tr>
                    <th>Appointment ID</th>
                    <th>Date & Time</th>
                    <th>Username</th>
                    <th>Clinic Name</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['appointmentId']); ?></td>
                    <td><?php echo htmlspecialchars($row['dateTime']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['clinicName']); ?></td>
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