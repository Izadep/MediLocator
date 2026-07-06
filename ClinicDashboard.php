<?php
session_start();
include 'database.php';
include 'clinicauth.php';

$userId = $_SESSION['user_id'] ?? null;

/* TOTAL CLINICS (ONLY THIS USER) */
$clinicCount = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM clinic 
    WHERE userId = '$userId'
"))['total'];

/* TOTAL PHARMACIES (OPTIONAL GLOBAL OR REMOVE) */
$pharmacyCount = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM pharmacy
"))['total'];

/* TOTAL REVIEWS (ONLY THIS USER’S CLINICS) */
$reviewCount = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM review r
    JOIN clinic c ON r.clinicId = c.clinicId
    WHERE c.userId = '$userId'
"))['total'];
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

        <div class="stat-card">
            <h2><?php echo $clinicCount; ?></h2>
            <p>My Clinics</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $reviewCount; ?></h2>
            <p>My Clinic Reviews</p>
        </div>

    </div>
    </div>
    </div>

        <?php include("footer.php") ?>
</body>
</html>