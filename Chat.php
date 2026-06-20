<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - MediLocator</title>
    <link rel="stylesheet" href="Chat.css">
</head>

<body>

    <nav class="NavBar" id="navbar">
        <div class="nav-contain">
            <a href="HomeScreen.php" class="logo">
                <img src="image/MedilocatorIslam.svg" alt="MediLocator Logo">
            </a>

            <div class="nav-links">
                <a href="HomeScreen.php" class="nav-item">Home</a>
                <a href="Appointment.php" class="nav-item">Appointment</a>
                <a href="Chat.php" class="nav-item active">Chat</a>

                <div class="dropdown">
                    <a href="Profile.php" class="dropbtn nav-item">
                        Profile ▼
                    </a>

                    <div class="dropdown-content">
                        <a href="Profile.php">My Account</a>
                        <a href="logout.php" style="color:red;">Log out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="page-content">

        <div class="chat-container">

            <div class="chat-header">
                <h1>💬 Chat</h1>
            </div>

            <div class="chat-body">
                <p>No chat history available.</p>
            </div>

        </div>

    </main>

    <footer class="footer">
            <p>&copy; 2026 MediLocator</p>
        </footer>

    <script>
        window.addEventListener('scroll', function () {
            var navbar = document.getElementById('navbar');

            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>