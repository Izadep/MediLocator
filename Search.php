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
    <link rel="stylesheet" href="Search.css">
</head>

<body>
    
 <nav class="NavBar" id="navbar">
        <div class="nav-contain">
            <a href="HomeScreen.php" class="logo">
                <img src="image/MedilocatorIslam.svg" alt="MediLocator Logo">
            </a>

            <div class="nav-links">
                <a href="HomeScreen.php" class="nav-item">Home</a>
                <a href="Appointment.php" class="nav-item">Appointment</a>
                <a href="Chat.php" class="nav-item">Chat</a>

                <div class="dropdown">
                    <button class="dropbtn nav-item">Profile ▼</button>
                    <div class="dropdown-content">
                        <a href="Profile.php">My Account</a>
                        <a href="logout.php" style="color: red;">Log out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

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

    $sql = "SELECT clinicName AS name,
                   address,
                   'Clinic' AS type
            FROM clinic
            ORDER BY clinicName";

} elseif ($category == 'pharmacy') {

    $sql = "SELECT pharmacyName AS name,
                   address,
                   'Pharmacy' AS type
            FROM pharmacy
            ORDER BY pharmacyName";

} else {

    $sql = "SELECT clinicName AS name,
                   address,
                   'Clinic' AS type
            FROM clinic
            WHERE clinicName LIKE '%$search%'

            UNION

            SELECT pharmacyName AS name,
                   address,
                   'Pharmacy' AS type
            FROM pharmacy
            WHERE pharmacyName LIKE '%$search%'

            ORDER BY name";
}

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $count = mysqli_num_rows($result);

    echo "<h2>{$count} Results found</h2>";

    echo "<div class='results-container'>";

    while ($row = mysqli_fetch_assoc($result)) {

        $typeClass = strtolower($row['type']);

        echo "
        <div class='healthcare-list'>
            <span class='type-badge {$typeClass}'>" . htmlspecialchars($row['type']) . "</span>
            <h3>" . htmlspecialchars($row['name']) . "</h3>
            <p>" . htmlspecialchars($row['address']) . "</p>
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
        <footer class="footer">
            <p>&copy; 2026 MediLocator</p>
        </footer>
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