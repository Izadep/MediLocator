<?php
session_start();
include("database.php");
if(!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}

$name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];

$userId = $_SESSION['user_id'];

$sql = "SELECT a.*, c.clinicName, c.address
        FROM appointment a
        JOIN clinic c ON a.clinicId = c.clinicId
        WHERE a.userId = '$userId'
        AND a.dateTime >= NOW()
        ORDER BY a.dateTime ASC
        LIMIT 1";

$result = mysqli_query($conn, $sql);
$appointment = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="Profile.css">
    <title>Profile</title>
</head>

<body>
    <?php include("navbar.php") ?>
    <!--<div class = "body-bg">
        <div id = "body-img">
        </div>
    </div>-->

   <div class="contentprofile">
        <div class="profile-container">

            <div class="profile-header slide-in">
                <div class="profile-pic">
                    <img src="<?php echo $_SESSION['user-img'] ?>" alt="Profile Picture">
                </div>

                <div class="profile-info">
                    <h2><?php echo $_SESSION['user_name']; ?></h2>
                    <p><?php echo $_SESSION['user_email']; ?></p>
                </div>
            </div>

            <div class="appointment-section slide-in" style="animation-delay: 0.1s;">
                <h2 class="section-title">My Appointments</h2>

                <div class="appointment-card">

                <?php if ($appointment): ?>

                    <div class="clinic-image"></div>

                    <div class="appointment-info">
                        <span class="appointment-date">
                            <?= date("d M Y, h:i A", strtotime($appointment['dateTime'])) ?>
                        </span>

                        <div class="healthcare-type">Clinic</div>

                        <p class="healthcare-name">
                            <b><?= htmlspecialchars($appointment['clinicName']) ?></b>
                        </p>

                        <p class="clinic-address">
                            <?= htmlspecialchars($appointment['address']) ?>
                        </p>

                        <a href="Details.php?id=<?= $appointment['clinicId'] ?>&type=clinic" class="details-link">
                            VIEW DETAILS →
                        </a>
                    </div>

                <?php else: ?>

                    <p style="padding: 20px; color: #777;">
                        No upcoming appointment
                    </p>

                <?php endif; ?>

                <button class="go-btn" onclick="location.href='Appointment.php'">Go</button>
            </div>
            </div>

            <div class="profile-menu slide-in" style="animation-delay: 0.2s;">
                <a href="History.php">📅 Appointment History</a>
                <a href="Settings.php">⚙️ Settings</a>
                <a href="logout.php" class="logout">🚪 Log Out</a>
            </div>
        </div>
   </div>

   <?php include("footer.php") ?>

    <script>
        window.addEventListener('scroll',function(){
            var navbar = document.getElementById('navbar');
            if(window.scrollY > 20) {
                navbar.classList.add('scrolled');
            }else{
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