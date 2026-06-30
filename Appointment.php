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
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="Appointment.css">
</head>

<body>
    <?php include("navbar.php") ?>
    <div class = "body-bg">
        <div id = "body-img">
        </div>
    </div>
        <div class="content slide-in">
            <div class="appointment-page">
                <div class="appointment-header">
                    <h1>Appointment</h1>
                </div>

                <div class="appointment-controls">
                    <div class="select-area">
                        <label for="appointmentUser">Select appointment for:</label>

                        <div class="custom-select-wrapper">
                            <select id="appointmentUser" name="appointmentUser">
                                <option value="user1"><?php echo $name . " (you)"?></option>
                                <option value="user2">User 2</option>
                            </select>
                        </div>
                    </div>
                    <a href="History.php" class="history-link">History</a>
                </div>

                <p class="no-appointment">(No upcoming appointment)</p>

                <hr>

                <div class="appointment-content">
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
    </script>
</body>
</html>