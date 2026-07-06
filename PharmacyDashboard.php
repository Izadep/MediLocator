<?php
session_start();
include 'database.php';
include 'pharmacyauth.php';

$userId = $_SESSION['user_id'] ?? null;

/* TOTAL PHARMACIES (ONLY THIS USER) */
$pharmacyCount = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM pharmacy 
    WHERE userId = '$userId'
"))['total'];

/* TOTAL REVIEWS (ALL REVIEWS OR YOU CAN FILTER LATER) */
$reviewCount = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM review r
    JOIN pharmacy p ON r.pharmacyId = p.pharmacyId
    WHERE p.userId = '$userId'
"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy Dashboard</title>
    <link rel="stylesheet" href="PharmacyDashboard.css">
</head>
<body>
    <div class = container>
     <?php include("navbarpharmacy.php") ?>
        
        <div class="admin-content">
            <div class="admin-title">MediLocator Pharmacy Dashboard</div>
            <h1>Healthcare Services Dashboard</h1>
            <div class="stat-cards">

        <div class="stat-card">
            <h2><?php echo $pharmacyCount; ?></h2>
            <p>My Pharmacies</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $reviewCount; ?></h2>
            <p>Total Reviews</p>
        </div>

    </div>
    </div>
    </div>

        <?php include("footer.php") ?>
</body>
</html>