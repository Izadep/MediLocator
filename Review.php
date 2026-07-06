<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include 'database.php';

$filterType = $_GET['type'] ?? '';
$filterId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (isset($_GET['delete']) && isset($_SESSION['logged_in'])) {
    $deleteId = (int)$_GET['delete'];
    $userId = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    mysqli_query($conn, "DELETE FROM review WHERE reviewId = $deleteId AND userId = '$userId'");
    header("Location: Review.php" . ($filterType && $filterId ? "?type=$filterType&id=$filterId" : ""));
    exit();
}

if ($filterType == 'clinic' && $filterId > 0) {
    $sql = "SELECT r.reviewId, r.rating, r.comments, r.reviewDate, r.userId,
                   u.name AS userName, c.clinicName AS placeName, u.picture as userPicture
            FROM review r
            LEFT JOIN users u ON r.userId = u.userId
            LEFT JOIN clinic c ON r.clinicId = c.clinicId
            WHERE r.clinicId = $filterId
            ORDER BY r.reviewDate DESC";
} elseif ($filterType == 'pharmacy' && $filterId > 0) {
    $sql = "SELECT r.reviewId, r.rating, r.comments, r.reviewDate, r.userId,
                   u.name AS userName, p.pharmacyName AS placeName, u.picture as userPicture
            FROM review r
            LEFT JOIN users u ON r.userId = u.userId
            LEFT JOIN pharmacy p ON r.pharmacyId = p.pharmacyId
            WHERE r.pharmacyId = $filterId
            ORDER BY r.reviewDate DESC";
} else {
    $sql = "SELECT r.reviewId, r.rating, r.comments, r.reviewDate, r.userId,
                   u.name AS userName,
                   COALESCE(c.clinicName, p.pharmacyName) AS placeName, u.picture as userPicture
            FROM review r
            LEFT JOIN users u ON r.userId = u.userId
            LEFT JOIN clinic c ON r.clinicId = c.clinicId
            LEFT JOIN pharmacy p ON r.pharmacyId = p.pharmacyId
            ORDER BY r.reviewDate DESC";
}

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

$reviews = [];

while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - MediLocator</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="review.css">
</head>
<body>
    <?php include("navbar.php") ?>

    <div class="content">
        <div class="review-page" style="padding: 100px; width: 100%;">

            <div class="review-header">
                <?php if ($filterType && $filterId): ?>
                    <a href="Details.php?id=<?php echo $filterId; ?>&type=<?php echo $filterType; ?>">Back</a>
                <?php endif; ?>
                <h1>Reviews</h1>
                <?php if (isset($_SESSION['logged_in'])): ?>
                    <a href="reviewform.php<?php echo ($filterType && $filterId) ? "?type=$filterType&id=$filterId" : ''; ?>"
                        class="btn-add-review">Write a Review</a>
                <?php else: ?>
                    <a href="Login.php" class="btn-add-review">Log in to Review</a>
                <?php endif; ?>
            </div>

            <div class="reviews-container">
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $row): ?>
                    <div class="review-card">
                        <div class="review-top">
                            <div class="review-user">
                                <div class="profile-pic">
                                    <img src="<?php echo htmlspecialchars($row['userPicture']); ?>" alt="Profile Picture">
                                </div>
                                <div class="user-info">
                                    <strong><?php echo htmlspecialchars($row['userName'] ?? 'Anonymous'); ?></strong>
                                    <small><?php echo htmlspecialchars($row['placeName'] ?? ''); ?></small>
                                </div>
                            </div>
                            <div class="review-right">
                                <div class="star-display">
                                    <?php
                                       $rating = (int)($row['rating'] ?? 0);
                                      for ($i = 1; $i <= 5; $i++):
                                     ?>
                                    <span style="color: <?php echo $i <= $rating ? '#f5a623' : '#ddd'; ?>; font-size:1.2rem;">★</span>
                                     <?php endfor; ?>
                                </div>
                                <small class="review-date">
                                    <?php echo htmlspecialchars($row['reviewDate']); ?>
                                </small>
                            </div>
                        </div>
                        <p><?php echo htmlspecialchars($row['comments']); ?></p>
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['user_id'] === $row['userId']): ?>
                            <a href="Review.php?delete=<?php echo $row['reviewId']; ?><?php echo ($filterType && $filterId) ? "&type=$filterType&id=$filterId" : ''; ?>"
                               onclick="return confirm('Delete your review?');"
                               class="btn-delete-review">🗑 Delete</a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet. Be the first to write one!</p>
                <?php endif; ?>
            </div>

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

        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '☀️Light Mode';
        }
    </script>
</body>
</html>