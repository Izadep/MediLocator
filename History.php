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
    <link rel="stylesheet" href="Appointment.css">
</head>

<body class="bodyhistory">
    <nav class="NavBar" id="navbar">
        <div class="nav-contain">
            <a href="HomeScreen.php" class="logo">
                <img src="image/MedilocatorIslam.svg" alt="MediLocator Logo">
            </a>

            <div class="nav-links">
                <a href="HomeScreen.php" class="nav-item">Home</a>
                <a href="Appointment.php" class="nav-item active">Appointment</a>
                <a href="Chat.php" class="nav-item">Chat</a>

                <div class="dropdown">
                    <button class="dropbtn nav-item">Profile ▼</button>
                    <div class="dropdown-content">
                        <a href="Profile.php">My Account</a>
                        <a href="logout.php" style="color: red;">Log out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="content slide-in">
        <div class="appointment-page">

            <div class="history-header">
                <h1>Appointment History</h1>
            </div>

            <div class="appointment-controls">
                <div class="select-area1">
                    <label for="appointmentUser">Select appointment for:</label>

                    <div class="custom-select-wrapper">
                        <select id="appointmentUser" name="appointmentUser">
                            <option value="user1"><?php echo $name . " (you)" ?></option>
                            <option value="user2">User 2</option>
                        </select>
                    </div>
                </div>

                <a href="Appointment.php" class="appointment-link">Appointment</a>
            </div>

            <p class="no-appointment">(No appointment recorded)</p>

            <hr>

            <div class="appointment-content">
                
            </div>
        </div>
    </div>

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

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const slideElements = document.querySelectorAll('.slide-in');
        slideElements.forEach(el => observer.observe(el));
    </script>

</body>
</html>