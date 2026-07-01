<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}
include 'database.php';

$userId = $_SESSION['user_id'];
$error = '';

$type = $_GET['type'] ?? '';
$refId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (($type !== 'clinic' && $type !== 'pharmacy') || $refId <= 0) {
    header("Location: Review.php");
    exit();
}

if ($type == 'clinic') {
    $res = mysqli_query($conn, "SELECT clinicName AS placeName FROM clinic WHERE clinicId = $refId");
} else {
    $res = mysqli_query($conn, "SELECT pharmacyName AS placeName FROM pharmacy WHERE pharmacyId = $refId");
}

$place = mysqli_fetch_assoc($res);
if (!$place) {
    header("Location: Review.php");
    exit();
}

$placeName = $place['placeName'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);
    $reviewDate = date('Y-m-d');

    if (empty(trim($comments))) {
        $error = "Please write a comment.";
    } else {
        if ($type == 'clinic') {
            $sql = "INSERT INTO review (rating, comments, reviewDate, userId, clinicId)
                    VALUES (NULL, '$comments', '$reviewDate', '$userId', $refId)";
        } else {
            $sql = "INSERT INTO review (rating, comments, reviewDate, userId, pharmacyId)
                    VALUES (NULL, '$comments', '$reviewDate', '$userId', $refId)";
        }

        if (mysqli_query($conn, $sql)) {
            header("Location: Review.php?type=$type&id=$refId");
            exit();
        } else {
            $error = "Failed to submit: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Review - MediLocator</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="review.css">
</head>
<body>
    <?php include("navbar.php") ?>

    <div class="content">
        <div class="review-page" style="padding: 30px; width: 100%;">

            <h1>Write a Review</h1>
                <div class="reviewing-banner">
                    <p>Reviewing</p>
                        <h2><?php echo htmlspecialchars($placeName); ?></h2>
                </div>

            <?php if ($error): ?>
                <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" class="review-form">
                <div class="form-group">
                    <label>Your Review</label>
                    <textarea name="comments" rows="5"
                        placeholder="Share your experience at <?php echo htmlspecialchars($placeName); ?>..."
                        required></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Submit Review</button>
                    <a href="Review.php?type=<?php echo $type; ?>&id=<?php echo $refId; ?>"
                       class="btn-cancel">Cancel</a>
                </div>
            </form>

        </div>
    </div>

    <?php include("footer.php") ?>
    <script>
        window.addEventListener('scroll', function () {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 20) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        if (localStorage.getItem('theme')=== 'dark') {
            body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '☀️Light Mode'
        }
    </script>
</body>
</html>