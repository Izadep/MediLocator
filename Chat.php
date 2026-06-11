<?php
// Example data (replace with database later)
$chats = [
    [
        "name" => "Klinik Ayer Keroh",
        "message" => "Hello, I'd like an inquiry about the availability of this week's checkup,",
        "date" => "Just now",
        "image" => "image/clinic.png"
    ],
    [
        "name" => "Watsons",
        "message" => "Hello, I'd like an inquiry about the availability of this product? May I know if it's still available?",
        "date" => "17 April",
        "image" => "image/watsons.png"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recent Chats</title>
    <link rel="stylesheet" href="Chat.css">
</head>

<body>
    <div class="NavBar">
        <a href="HomeScreen.php" class="nav-item">Home</a>
        <a href="Profile.php" class="nav-item">Profile</a>
        <a href="Appointment.php" class="nav-item active">Appointment</a>
        <a href="Chat.php" class="nav-item">Chat</a>
    </div>
    <div class="chat-page">
        <div class="chat-header">
            <h1>Chat</h1>
        </div>

        <div class="chat-controls">
            <div class="select-chat-area">
                <p>(No Chat History Recorded)</p>
            </div>
        </div>

        <div class="chat-content">

            <div class="footer">
                <img src="image\MedilocatorIslam.svg" alt="MediLocator Logo">
            </div>
        </div>
    </div>
</body>
</html>