<?php
session_start();
include 'database.php';


$userCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$clinicCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM clinic"))['total'];
$pharmacyCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pharmacy"))['total'];
$appointmentCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointment"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav class="admin-nav">
        <div class="admin-nav-title">MediLocator Admin</div>
        <div class="admin-nav-links">
            <a href="admindashboard.php">Dashboard</a>
            <a href="manageusers.php">Users</a>
            <a href="manageclinic.php">Clinics</a>
            <a href="managepharmacy.php">Pharmacies</a>
            <a href="manageappointment.php">Appointments</a>
            <a href="logout.php" style="color:#ffb3b3;">Log out (<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>)</a>
        </div>
    </nav>

    <div class="admin-content">
        <h1>Dashboard</h1>
        <div class="stat-cards">
            <div class="stat-card"><h2><?php echo $userCount; ?></h2><p>Users</p></div>
            <div class="stat-card"><h2><?php echo $clinicCount; ?></h2><p>Clinics</p></div>
            <div class="stat-card"><h2><?php echo $pharmacyCount; ?></h2><p>Pharmacies</p></div>
            <div class="stat-card"><h2><?php echo $appointmentCount; ?></h2><p>Appointments</p></div>
        </div>
    </div>
</body>
</html>