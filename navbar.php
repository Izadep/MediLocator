<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

    <nav class="NavBar" id="navbar">
        <div class="nav-contain">
            <a href="HomeScreen.php" class="logo">
                <img src="image/MedilocatorIslam.svg" alt="MediLocator Logo">
            </a>

            <div class="nav-links">
                <a href="HomeScreen.php" class="nav-item <?= $currentPage == 'HomeScreen.php' ? 'active' : '' ?>">
                    Home
                </a>

                <a href="Appointment.php" class="nav-item <?= $currentPage == 'Appointment.php' ? 'active' : '' ?>">
                    Appointment
                </a>

                <div class="dropdown">
                    <a href="Profile.php" class="dropbtn nav-item">
                        Profile ▼
                    </a>
                    <div class="dropdown-content">
                        <a href="Profile.php">My Account</a>
                        <a href="logout.php" style="color: red;">Log out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>