<?php
include("database.php");
session_start();
if(!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$name = $_SESSION['user_name'];

$sql = "SELECT a.*, c.clinicName, c.address
        FROM appointment a
        JOIN clinic c ON a.clinicId = c.clinicId
        WHERE a.userId = '$userId'
        AND a.status = 'Pending'
        ORDER BY a.dateTime ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="Appointment.css">
</head>

<body>
    <?php include("navbar.php") ?>
    <!--<div class = "body-bg">
        <div id = "body-img">
        </div>
    </div>-->
        <div class="content slide-in">
            <div class="appointment-page">
                <div class="appointment-header">
                    <h1>Appointment</h1>
                </div>

                <div class="appointment-controls">
                    <div class="select-area">
                        <label for="appointmentUser">Username:</label>

                        <div class="custom-select-wrapper">
                            <div class="user-display">
                                <?= htmlspecialchars($name) ?>
                            </div>
                        </div>
                    </div>
                    <a href="History.php" class="history-link">History</a>
                </div>
                <hr>
                <div class="appointment-content">

                <?php if ($result && mysqli_num_rows($result) > 0): ?>

                     <?php while($row = mysqli_fetch_assoc($result)): ?>

                        <?php
                            $appointmentDate = strtotime($row['dateTime']);
                            $now = time();
                            $isDue = ($now >= $appointmentDate);

                            $isNearby = false;

                            if ($appointmentDate) {
                                $diff = $appointmentDate - $now;
                                $isNearby = ($diff >= 0 && $diff <= 86400);
                            }
                        ?>
                        <div class="appointment-card <?= $isNearby ? 'nearby' : '' ?>">
                            <?php if ($isDue && $row['status'] == 'Pending'): ?>
                                <form method="POST" action="updateStatus.php" class="history-btn-form">
                                    <input type="hidden" name="appointmentId" value="<?= $row['appointmentId'] ?>">
                                    <button type="submit" class="history-btn">
                                        Move to History
                                    </button>
                                </form>
                            <?php endif; ?>
                            <?php if ($isNearby): ?>
                            <div class="badge">UPCOMING</div>
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($row['clinicName']) ?></h3>
                            <p>📍 <?= htmlspecialchars($row['address']) ?></p>
                            <p>📅 <?= date("d M Y", strtotime($row['dateTime'])) ?></p>
                            <p class="<?= $isNearby ? 'time-red' : '' ?>">
                                ⏰ <?= date("h:i A", strtotime($row['dateTime'])) ?>
                            </p>
                            <p>🧾 Type: <?= htmlspecialchars($row['type']) ?></p>
                        </div>

                    <?php endwhile; ?>
                    <?php else: ?>
                    <p class="no-appointment">(No upcoming appointment)</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php include("footer.php") ?>
    <script>
        window.addEventListener('scroll',function(){
                var navbar= document.getElementById('navbar');
                if(window.scrollY > 20) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            })

            const observerOptions= {
                root: null, rootMargin: '0px', thresold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
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