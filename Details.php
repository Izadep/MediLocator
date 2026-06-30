<?php
session_start();
include("database.php");

$id = $_GET['id'] ?? 0;
$type = $_GET['type'] ?? '';

$id = (int)$id;

if ($type == "clinic") {

    $sql = "SELECT *
            FROM clinic
            WHERE clinicId = $id";

}
elseif ($type == "pharmacy") {

    $sql = "SELECT *
            FROM pharmacy
            WHERE pharmacyId = $id";

}
else {
    die("Invalid type.");
}

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Data not found.");
}

$row = mysqli_fetch_assoc($result);

$image = ($type == "clinic")
    ? $row['clinicImage']
    : $row['pharmacyImage'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel= "stylesheet" href="Main.css">
    <link rel= "stylesheet" href="Details.css">
</head>
<body>
    <?php include("navbar.php") ?>

    <div class="body-bg">
        <div id="body-img">
        </div>
    </div>

    <div class="details-container">

        <div class="details-card">

            <div class="healthcare-image">
                <img src="<?php echo htmlspecialchars($image); ?>" alt="Healthcare Image">
            </div>

            <div class="healthcare-info">
                <h2><?php echo htmlspecialchars($row['clinicName'] ?? $row['pharmacyName']); ?></h2>

                <div class="rating-status">
                    ⭐ 4.6 (33 reviews)
                    <span class="status open">OPEN</span>
                </div>

                <div class="action-buttons">
                    <button>📞 Call</button>
                    <button>💬 Message</button>
                    <button>📍 Direction</button>
                    <button>🔗 Share</button>
                </div>

                <div class="info">
                    <p>📍 <?php echo htmlspecialchars($row['address']); ?></p>
                    <p>📞 <?php echo htmlspecialchars($row['phoneNum']); ?></p>
                    <p>➕ <?php echo htmlspecialchars($row['specialty']); ?></p>
                </div>

                <a href="Appointment.php" class="book-btn">
                    Book Appointment
                </a>
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
            root: null, rootMargin: '0px', threshold: 0.1
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