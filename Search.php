<?php
session_start();
include 'database.php';

$search = $_GET['search'] ?? '';
$search = mysqli_real_escape_string($conn, $search);
$category = $_GET['category'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="Search.css">
</head>

<body>
    <?php include("navbar.php") ?>
    <!--<div class = "body-bg">
        <div id = "body-img">
        </div>
    </div>-->
    <div class = "container">
        <form action="Search.php" method="get" class="slide-in" style="animation-delay: 0.2s;">
            <div class="search-container">
                <input type="text" name="search" placeholder="Search Clinic or Pharmacy" id="SearchBar" required>
                <button type="submit" class="search-icon">
                    <img src="image/kanta.png">
                </button>
            </div>
        </form>
        <div class = "page-content">
<?php

if ($category == 'clinic') {

    $sql = "SELECT clinicId AS id,
                clinicName AS name,
                address,
                clinicImage AS image,
                opHourStart,
                opHourEnd,
                'Clinic' AS type
            FROM clinic";

} elseif ($category == 'pharmacy') {

    $sql = "SELECT pharmacyId AS id,
                pharmacyName AS name,
                address,
                pharmacyImage AS image,
                opHourStart,
                opHourEnd,
                'Pharmacy' AS type
            FROM pharmacy";

} else {

    $sql = "SELECT clinicId AS id,
                clinicName AS name,
                address,
                clinicImage AS image,
                opHourStart,
                opHourEnd,
                'Clinic' AS type
            FROM clinic
            WHERE clinicName LIKE '%$search%'

            UNION

            SELECT pharmacyId AS id,
                pharmacyName AS name,
                address,
                pharmacyImage AS image,
                opHourStart,
                opHourEnd,
                'Pharmacy' AS type
            FROM pharmacy
            WHERE pharmacyName LIKE '%$search%'
            ORDER BY name";
}

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $count = mysqli_num_rows($result);

    echo "<div class='result-count'>{$count} Results found</div>";

    echo "<div class='results-container'>";

    while ($row = mysqli_fetch_assoc($result)) {

        $typeClass = strtolower($row['type']);

        date_default_timezone_set("Asia/Kuala_Lumpur");

        $currentTime = date("H:i:s");
        $openTime = $row['opHourStart'] ?? null;
        $closeTime = $row['opHourEnd'] ?? null;

        $isOpen = false;

        if ($openTime && $closeTime) {
            if ($openTime <= $closeTime) {
                $isOpen = ($currentTime >= $openTime && $currentTime <= $closeTime);
            } else {
                $isOpen = ($currentTime >= $openTime || $currentTime <= $closeTime);
            }
        }


        echo "
        <div class='healthcare-list'>
            <div class='badge-container'>
            <span class='type-badge {$typeClass}'>
                " . htmlspecialchars($row['type']) . "
            </span>

            <span class='status-badge " . ($isOpen ? "open" : "closed") . "'>
                " . ($isOpen ? "OPEN" : "CLOSED") . "
            </span>
        </div>

            <div class='card-main'>
                <h3>" . htmlspecialchars($row['name']) . "</h3>
                <p>" . htmlspecialchars($row['address']) . "</p>
            </div>

            <div class='card-expand'>
                <div class='button-container'>
                     <a href='Details.php?id=" . $row['id'] . "&type={$typeClass}" . "&return=" . urlencode($_SERVER['REQUEST_URI']) . "' class='details-btn'>
                        View Details
                    </a>
                </div>
            </div>
        </div>";
    }

    echo "</div>";

} else {

    echo "
    <div class='no-list'>
        <p>(No result found for <b>" . htmlspecialchars($search) . "</b>)</p>
    </div>";
}
?>
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