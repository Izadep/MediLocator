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
    <title>Appointment History</title>
    <link rel="stylesheet" href="History.css">
</head>
<body>

    <div class="NavBar">
        <a href="HomeScreen.php" class="nav-item">Home</a>
        <a href="Profile.php" class="nav-item">Profile</a>
        <a href="Appointment.php" class="nav-item active">Appointment</a>
        <a href="Chat.php" class="nav-item">Chat</a>
    </div>

    <div class="appointment-page">
        <div class="appointment-header">
            <h1>Appointment History</h1>
        </div>

        <div class="appointment-controls">
            <div class="select-area">
                <label for="appointmentUser">Select appointment for :</label>
                <select id="appointmentUser" name="appointmentUser">
                    <option value="user1"><?php echo $name . " (you)"?></option>
                    <option value="user2">User 2</option>
                </select>
            </div>

            <a href="Appointment.php" class="appointment-link">Appointment</a>

        </div>

        <p class="no-appointment">(No appointment recorded)</p>

        <hr>

        <div class="appointment-content">

            <div class="footer">
                <img src="image\MedilocatorIslam.svg" alt="MediLocator Logo">
            </div>
        </div>
    </div>

</body>
</html>