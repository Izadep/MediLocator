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

// Get place name
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
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);
    $reviewDate = date('Y-m-d');

    if ($rating < 1 || $rating > 5) {
        $error = "Please select a rating.";
    } elseif (empty(trim($comments))) {
        $error = "Please write a comment.";
    } else {
        if ($type == 'clinic') {
            $sql = "INSERT INTO review (rating, comments, reviewDate, userId, clinicId)
                    VALUES ($rating, '$comments', '$reviewDate', '$userId', $refId)";
        } else {
            $sql = "INSERT INTO review (rating, comments, reviewDate, userId, pharmacyId)
                    VALUES ($rating, '$comments', '$reviewDate', '$userId', $refId)";
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
    <link rel="stylesheet" href="Review.css">
    <style>
        .star-input {
            display: flex;
            flex-direction: row;
            gap: 4px;
        }
        .star-input input[type="radio"] {
            display: none;
        }
        .star-label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.15s;
        }
        .star-label.selected,
        .star-label.hovered {
            color: #f5a623;
        }
    </style>
</head>
<body>
    <?php include("navbar.php") ?>

    <div class="content">
        <div class="review-page" style="padding: 30px; width: 100%;">

            <div class="reviewing-banner">
                <p>Reviewing</p>
                <h2><?php echo htmlspecialchars($placeName); ?></h2>
            </div>

            <?php if ($error): ?>
                <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" class="review-form">

                <div class="form-group">
                    <label>Rating</label>
                    <div class="star-input" id="starInput">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" name="rating" id="star<?php echo $i; ?>" value="<?php echo $i; ?>">
                            <label for="star<?php echo $i; ?>" class="star-label" data-value="<?php echo $i; ?>">★</label>
                        <?php endfor; ?>
                    </div>
                </div>

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

        const stars = document.querySelectorAll('.star-label');
        let selectedRating = 0;

        stars.forEach(function(star) {
            star.addEventListener('mouseover', function() {
                let val = parseInt(this.getAttribute('data-value'));
                stars.forEach(function(s) {
                    s.style.color = parseInt(s.getAttribute('data-value')) <= val ? '#f5a623' : '#ddd';
                });
            });

            star.addEventListener('mouseout', function() {
                stars.forEach(function(s) {
                    s.style.color = parseInt(s.getAttribute('data-value')) <= selectedRating ? '#f5a623' : '#ddd';
                });
            });

            star.addEventListener('click', function() {
                selectedRating = parseInt(this.getAttribute('data-value'));
                document.getElementById('star' + selectedRating).checked = true;
                stars.forEach(function(s) {
                    s.style.color = parseInt(s.getAttribute('data-value')) <= selectedRating ? '#f5a623' : '#ddd';
                });
            });
            
        });
    </script>
</body>
</html>