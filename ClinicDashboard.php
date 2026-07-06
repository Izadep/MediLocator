<?php
session_start();
include 'database.php';
include 'clinicauth.php';

$userCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$clinicCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM clinic"))['total'];
$pharmacyCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pharmacy"))['total'];
$appointmentCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointment"))['total'];
$reviewCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM review"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clinic Dashboard</title>
    <link rel="stylesheet" href="ClinicDashboard.css">
</head>
<body>
    <div class = container>
     <?php include("navbarclinic.php") ?>
    
    <div class="admin-content">
        <div class="admin-title">MediLocator Clinic Dashboard</div>
        <h1>Healthcare Services Dashboard</h1>
        <div class="stat-cards">
            <div class="stat-card"><h2><?php echo $clinicCount; ?></h2><p>Clinics</p></div>
            <div class="stat-card"><h2><?php echo $pharmacyCount; ?></h2><p>Pharmacies</p></div>
            <div class="stat-card"><h2><?php echo $appointmentCount; ?></h2><p>Appointments</p></div>
            <div class="stat-card"><h2><?php echo $reviewCount; ?></h2><p>Review</p></div>
        </div>
    </div>
    </div>

        <?php include("footer.php") ?>
</body>
</html>