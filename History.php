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
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="Appointment.css">
</head>

<body class="bodyhistory">
    <?php include("navbar.php") ?>
    <!-- <div class = "body-bg">
        <div id = "body-img">
        </div> -->
    </div>
    <div class="content slide-in">
        <div class="appointment-page">

            <div class="history-header">
                <h1>Appointment History</h1>
            </div>

            <div class="appointment-controls">
                <div class="select-area1">
                    <label for="appointmentUser">Username:</label>

                    <div class="custom-select-wrapper">
                        <div class="user-display">
                            <?= htmlspecialchars($name) ?>
                        </div>
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

    <?php include("footer.php") ?>
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