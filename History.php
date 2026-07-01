<?php
session_start();
include("database.php");

if(!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}
$userId = $_SESSION['user_id'];
$sql = "SELECT a.*, c.clinicName, c.address
        FROM appointment a
        JOIN clinic c ON a.clinicId = c.clinicId
        WHERE a.userId = '$userId'
        AND a.status = 'History'
        ORDER BY a.dateTime DESC";

$result = mysqli_query($conn, $sql);

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

            <hr>

            <div class="appointment-content">

            <?php if ($result && mysqli_num_rows($result) > 0): ?>

                <?php while($row = mysqli_fetch_assoc($result)): ?>

                    <div class="appointment-history-card">

                        <h3><?= htmlspecialchars($row['clinicName']) ?></h3>

                        <p>📍 <?= htmlspecialchars($row['address']) ?></p>

                        <p>📅 <?= date("d M Y", strtotime($row['dateTime'])) ?></p>

                        <p>⏰ <?= date("h:i A", strtotime($row['dateTime'])) ?></p>

                        <p>🧾 Type: <?= htmlspecialchars($row['type']) ?></p>

                        <p style="color: gray; font-weight: bold;">
                            Status: <?= htmlspecialchars($row['status']) ?>
                        </p>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>
                <p class="no-appointment">(No Appointment Recorded)</p>
            <?php endif; ?>

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

        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        if (localStorage.getItem('theme')=== 'dark') {
            body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '☀️Light Mode'
        }
    </script>

</body>
</html>