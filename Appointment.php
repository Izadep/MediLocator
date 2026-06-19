<?php
session_start();
if(!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}

$name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment</title>
    <link rel="stylesheet" href="Appointment.css">
</head>
<body>
    <nav id="navbar">
        <div class="nav-container">
            <a href="HomeScreen.php" class="logo">
                <img src="image/MedilocatorIslam.svg">
            </a>

            <div calss="nav-links">
                <a href="HomeScreen.html" class="nav-item">Home</a>
                <a href="Appointment.html" class="nav-item active">Appointment</a>
                <a href="Chat.html" class="nav-item">Chat</a>
                <div class="dropdown">
                    <button class="dropbtn nav-item">Profile</button>
                    <div class="dropdown-content">
                        <a href="Profile.html">My Account</a>
                        <a href="#">Settings</a>
                        <a href="Login.html">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
   

   <div class="content slide-in">
        <div class="appointment-page">

            <div class="appointment-header">
                <h1>Appointment</h1>
            </div>

            <div class="appointment-controls">
                <div class="select-area">
                    <label for="appointmentUser">Select appointment for :</label>
                    <div class="custom-select-wrapper">
                                <select id="appointmentUser" name="appointmentUser">
                                    <option value="user1"><?php echo $name . " (you)"?></option>
                                    <option value="user2">User 2</option>
                                </select>
                    </div>
            </div>

            <a href="History.php" class="history-link">History</a>

        <   /div>

        <p class="no-appointment">(No upcoming appointment)</p>

        <hr>

        <div class="appointment-content">

            <div class="footer">
                <img src="image\MedilocatorIslam.svg" alt="MediLocator Logo">
            </div>
        </div>
        </div>
   </div>

</body>
</html>