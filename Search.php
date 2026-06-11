<?php
session_start();
include 'database.php';

$search = $_GET['search'] ?? '';
$search = mysqli_real_escape_string($conn, $search);
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

<div class="NavBar">
    <a href="HomeScreen.php" class="nav-item">Home</a>
    <a href="Profile.php" class="nav-item">Profile</a>
    <a href="Appointment.php" class="nav-item">Appointment</a>
    <a href="Chat.php" class="nav-item">Chat</a>
</div>

<form action="Search.php" method="GET">
    <div class="search-container">
        <button type="submit" class="search-icon">
            <img src="image/magnifyingGlass.png" alt="search">
        </button>
        <input type="text" name="search" id="SearchBar" placeholder="Search clinic..." value="<?php echo htmlspecialchars($search); ?>">
    </div>
</form>

<h1>Search Results</h1>

<?php
$sql = "SELECT clinicName AS name, address FROM clinic WHERE clinicName LIKE '%$search%'
        UNION
        SELECT pharmacyName AS name, address FROM pharmacy WHERE pharmacyName LIKE '%$search%' ORDER BY name";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $count = mysqli_num_rows($result);

    echo "<h2>{$count} Results found</h2>";

    echo "<div class='results-container'>";
    while ($row = mysqli_fetch_assoc($result)) {

        echo "
        <div class='healthcare-list'>
            <h3>" . htmlspecialchars($row['name']) . "</h3>
            <p>" . htmlspecialchars($row['address']) . "</p>
        </div>";
    }
    echo "</div>";

} else {
    echo "<div class='no-list'>
    <p>(No result found for <b>" . htmlspecialchars($search) . "</b>)</p>
    </div>";
}
?>

</body>
</html>