<?php
session_start();
if(!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}

$name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Profile.css">
    <title>Profile</title>
</head>
<body>
    <div class="NavBar">
        <a href="HomeScreen.php" class="nav-item">Home</a>
        <a href="Profile.php" class="nav-item">Profile</a>
        <a href="Appointment.php" class="nav-item active">Appointment</a>
        <a href="Chat.php" class="nav-item">Chat</a>
    </div>
    <div class="profile-container">

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-pic">
                <img src="image/user-icon.png" alt="Profile Picture">
            </div>

            <div class="profile-info">
                <h2><?php echo $_SESSION['user_name']; ?></h2>
                <p><?php echo $_SESSION['user_email']; ?></p>
            </div>
        </div>

        <!-- Appointment Section -->
        <div class="appointment-section">
            <h2>My Appointments</h2>

            <div class="appointment-card">
                <div class="clinic-image"></div>

                <div class="appointment-info">
                    <span class="appointment-date">
                        📅 Friday, 22/5/2026 (Tomorrow)
                    </span>

                    <p class="healthcare-type">Clinic</p>
                    <p class="healthcare-name"><b>
                    Klinik Ayer Keroh</b></p>

                    <p class="clinic-address">
                        Klinik Ayer Keroh, 25, Lorong ...
                    </p>

                    <a href="#">APPOINTMENT DETAILS</a>
                </div>

                <button class="go-btn">Go</button>
            </div>
        </div>

        <!-- Menu Section -->
        <div class="profile-menu">
            <a href="History.php">Appointment History</a>
            <a href="Saved.php">Saved Clinics / Pharmacies</a>
            <a href="Settings.php">Settings</a>
            <a href="logout.php" class="logout">Log Out</a>
        </div>
    </div>
</body>
</html>