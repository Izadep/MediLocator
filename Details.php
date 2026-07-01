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

date_default_timezone_set("Asia/Kuala_Lumpur");

$currentTime = date("H:i:s");

$openTime = $row['opHourStart'];
$closeTime = $row['opHourEnd'];

$isOpen = false;

if ($openTime && $closeTime) {
    if ($openTime <= $closeTime) {
        $isOpen = ($currentTime >= $openTime && $currentTime <= $closeTime);
    } else {
        $isOpen = ($currentTime >= $openTime || $currentTime <= $closeTime);
    }
}
$reviewQuery = "SELECT COUNT(*) AS totalReviews FROM review WHERE clinicId = $id";
$reviewResult = mysqli_query($conn, $reviewQuery);
$reviewRow = mysqli_fetch_assoc($reviewResult);

$totalReviews = $reviewRow['totalReviews'];
$image = ($type == "clinic")
    ? $row['clinicImage']
    : $row['pharmacyImage'];
$lat = $row['latitude'];
$lng = $row['longitude'];

$googleLink = "https://www.google.com/maps?q=$lat,$lng";
$wazeLink = "https://waze.com/ul?ll=$lat,$lng&navigate=yes";
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
        <div id="body-img" style="background-image: url('<?php echo htmlspecialchars($image); ?>');"></div>
    </div>

    <div class="details-container">

        <div class="details-card">

            <div class="healthcare-image">
                <img src="<?php echo htmlspecialchars($image); ?>" alt="Healthcare Image">
            </div>

            <div class="healthcare-info">
                <h2><?php echo htmlspecialchars($row['clinicName'] ?? $row['pharmacyName']); ?></h2>

                <div class="rating-status">
                    ⭐ <?= $totalReviews ?> Reviews
                    <span class="status <?= $isOpen ? 'open' : 'closed' ?>">
                        <?= $isOpen ? 'OPEN' : 'CLOSED' ?>
                    </span>
                </div>

                <div class="hours-info">
                    🕒 <?= date("h:i A", strtotime($openTime)) ?> - <?= date("h:i A", strtotime($closeTime)) ?>
                </div>
                
                <div class="action-buttons">
                    <button onclick="copyPhone('<?= $row['phoneNum'] ?>')" class="call-btn" title="Copy phone-number">📞 Call</button>
                    <button class="review-btn"
                        onclick="window.location.href='Review.php?id=<?= $id ?>&type=<?= $type ?>'">
                        ⭐ Review
                    </button>                   
                    <button onclick="openDirectionModal()" title="Get Direction">📍 Direction</button>
                    <button onclick="copyLink()" class="share-btn" title="Copy link">🔗 Share</button>
                </div>

                <div class="info">
                    <p>📍 <?php echo htmlspecialchars($row['address']); ?></p>
                    <p>📞 <?php echo htmlspecialchars($row['phoneNum']); ?></p>
                    <?php if (!empty($row['specialty'])): ?>
                        <p>➕ <?php echo htmlspecialchars($row['specialty']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="button-row">
                <a href="javascript:void(0)" class="back-btn" onclick="window.history.back()">
                    ← Back
                </a>
                <?php if ($type == "clinic"): ?>
                    <a href="BookAppointment.php?id= <?= $row['clinicId'] ?>" class="book-btn">
                        Book Appointment
                    </a>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="directionModal" class="modal">
    <div class="modal-content">
            <h3>Choose Navigation</h3>

            <a href="<?= $googleLink ?>" target="_blank" class="btn google">
                📍 Google Maps
            </a>

            <a href="<?= $wazeLink ?>" target="_blank" class="btn waze">
                🚗 Waze
            </a>

            <button onclick="closeDirectionModal()" class="btn close">
                Cancel
            </button>
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
    <script>
    function openDirectionModal() {
        document.getElementById("directionModal").style.display = "flex";
    }

    function closeDirectionModal() {
        document.getElementById("directionModal").style.display = "none";
    }

    // click outside to close
    window.onclick = function(event) {
        let modal = document.getElementById("directionModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            let toast = document.createElement("div");
            toast.innerText = "Link copied!";
            toast.style.position = "fixed";
            toast.style.bottom = "20px";
            toast.style.left = "50%";
            toast.style.transform = "translateX(-50%)";
            toast.style.background = "#333";
            toast.style.color = "#fff";
            toast.style.padding = "10px 20px";
            toast.style.borderRadius = "8px";
            toast.style.zIndex = "9999";
            toast.style.fontSize = "14px";
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 1500);
        });
    }
    function copyPhone(phone) {
        navigator.clipboard.writeText(phone).then(() => {
            let toast = document.createElement("div");
            toast.innerText = "Phone number copied!";
            toast.style.position = "fixed";
            toast.style.bottom = "20px";
            toast.style.left = "50%";
            toast.style.transform = "translateX(-50%)";
            toast.style.background = "#333";
            toast.style.color = "#fff";
            toast.style.padding = "10px 20px";
            toast.style.borderRadius = "8px";
            toast.style.zIndex = "9999";
            toast.style.fontSize = "14px";

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 1500);
        });
    }
    </script>
</body>
</html>