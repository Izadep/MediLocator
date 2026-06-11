<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Screen</title>
    <link rel= "stylesheet" href="HomeScreen.css">
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
            <img src="image/magnifyingGlass.png">
        </button>
        <input type="text" name="search" placeholder="Search Clinic or Pharmacy..." id="SearchBar">
    </div>
    </form>
    <!--<div class ="profile-container">
        <div id="ProfPart">
            <a href="Profile.php">
                <img id="ProfilePic" src="image/ProfileEmpty.png">
            </a>
            <div id="Username">
                <a>[Name]</a>
            </div> 
        </div>
    </div> -->
    <!-- <div class="sidebar">
        <a href="HomeScreen.php">Home</a>
        <a href="Profile.php">Profile</a>
        <a href="Appointment.php">Appointment</a>
        <a href="Chat.php">Chat</a>
    </div> -->
    <div class="content">
    <div class="mapAyerKeroh">
        <div id="map-container">
            <div id="loc-container">
                <img src="image/marker-container.png" id="marker-image">
                <div class="current-location">Melaka, Malaysia</div>
                <div class="area-name">(Ayer Keroh)</div>
            </div>

            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3986.6844052725155!2d102.28686109116023!3d2.271083557748551!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sgl!2smy!4v1781063671548!5m2!1sen!2sus"
                id="map" allowfullscreen loading="lazy"></iframe>
        </div>
    </div>

        <div class="quickcategories-container">
            <div class="categories-box">
                <div class="category">
                    <img src="image/Clinic-icon.png" alt="">
                    <span>Clinic</span>
                </div>

                <div class="category">
                    <img src="image/pharmacy-icon.png" alt="">
                    <span>Pharmacy</span>
                </div>

                <div class="category">
                    <img src="image/specialist-icon.png" alt="">
                    <span>Specialist</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>