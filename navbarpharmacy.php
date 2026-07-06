<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="admin-nav">
        <img src="image/MedilocatorIslam.svg" alt="MediLocator Logo">

        <div class="admin-nav-links">

            <a href="PharmacyDashboard.php" class="navadmin-item <?= $currentPage == 'PharmacyDashboard.php' ? 'active' : '' ?>">
                Dashboard</a>

            <a href="managepharmacy(Pharmacy).php" class="navadmin-item <?= $currentPage == 'managepharmacy(Pharmacy).php' ? 'active' : '' ?>">
                Pharmacy</a>

            <a href="managereview(Pharmacy).php" class="navadmin-item <?= $currentPage == 'managereview(Pharmacy).php' ? 'active' : '' ?>">
                Review</a>
                
            <a href="logout.php" class="navadmin-item" style="color:#8B0000;">Log out (<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>)</a>
        </div>
    </nav>