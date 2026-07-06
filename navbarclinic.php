<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="admin-nav">
        <img src="image/MedilocatorIslam.svg" alt="MediLocator Logo">

        <div class="admin-nav-links">

            <a href="ClinicDashboard.php" class="navadmin-item <?= $currentPage == 'ClinicDashboard.php' ? 'active' : '' ?>">
                Dashboard</a>

            <a href="manageclinic(Clinic).php" class="navadmin-item <?= $currentPage == 'manageclinic(Clinic).php' ? 'active' : '' ?>">
                Clinics</a>

            <a href="manageappointment(Clinic).php" class="navadmin-item <?= $currentPage == 'manageappointment(Clinic).php' ? 'active' : '' ?>">
                Appointments</a>

            <a href="managereview(Clinic).php" class="navadmin-item <?= $currentPage == 'managereview(Clinic).php' ? 'active' : '' ?>">
                Review</a>
                
            <a href="logout.php" class="navadmin-item" style="color:#ffb3b3;">Log out (<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>)</a>
        </div>
    </nav>