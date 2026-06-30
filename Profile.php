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
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="Profile.css">
    <title>Profile</title>
</head>

<body>
    <?php include("navbar.php") ?>
    <div class = "body-bg">
        <div id = "body-img">
        </div>
    </div>

   <div class="content">
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
                    <div class="clinic-image"></div>

                   <!-- <div class="appointment-info">
                         <span class="appointment-date">Tomorrow, 10:00 AM</span>
                        
                        <div class="healthcare-type">Clinic</div>
                        <p class="healthcare-name"><b>Klinik Ayer Keroh</b></p>
                        <p class="clinic-address">Klinik Ayer Keroh, 25, Lorong ...</p>
                        
                        <a href="#" class="details-link">VIEW DETAILS →</a>
                    </div>-->

                    <button class="go-btn">Go</button>
                </div>
            </div>

            <div class="profile-menu slide-in" style="animation-delay: 0.2s;">
                <a href="History.php">📅 Appointment History</a>
                <a href="Saved.php">❤️ Saved Clinics / Pharmacies</a>
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