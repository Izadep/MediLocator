<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="admin-nav">
        <img src="image/MedilocatorIslam.svg" alt="MediLocator Logo">

        <div class="admin-nav-links">

            <a href="admindashboard.php" class="navadmin-item <?= $currentPage == 'admindashboard.php' ? 'active' : '' ?>">
                Dashboard</a>

            <a href="manageusers.php" class="navadmin-item <?= $currentPage == 'manageusers.php' ? 'active' : '' ?>">
                Users</a>

            <a href="manageclinic.php" class="navadmin-item <?= $currentPage == 'manageclinic.php' ? 'active' : '' ?>">
                Clinics</a>

            <a href="managepharmacy.php" class="navadmin-item <?= $currentPage == 'managepharmacy.php' ? 'active' : '' ?>">
                Pharmacies</a>

            <a href="manageappointment.php" class="navadmin-item <?= $currentPage == 'manageappointment.php' ? 'active' : '' ?>">
                Appointments</a>
                
            <a href="logout.php" class="navadmin-item" style="color:#ffb3b3;">Log out (<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>)</a>
        </div>
    </nav>