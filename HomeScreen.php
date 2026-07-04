<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Screen</title>
    <link rel= "stylesheet" href="Main.css">
    <link rel= "stylesheet" href="HomeScreen.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
</head>
<body>
    <?php include("navbar.php") ?>

    <div class = "body-bg">
        <div id = "body-img">
        </div>
    </div>
    <div class="content">
        <div class="IntroMedilocator-container">
            <h2>Welcome To MediLocator!</h2>

            <div class="medilocator-info">
                <p>
                    MediLocator helps users quickly find nearby clinics,
                    pharmacies, and healthcare specialists. Search for medical
                    services, view locations on the map, and access healthcare
                    information conveniently from one platform.
                </p>
            </div>
        </div>
        <form action="Search.php" method="get" class="slide-in" style="animation-delay: 0.2s;">
            <div class="search-container">
                <input type="text" name="search" placeholder="Search Clinic or Pharmacy" id="SearchBar" required>
                <button type="submit" class="search-icon">
                    <img src="image/kanta.png">
                </button>
            </div>
        </form>

        <div class="quickcategories-container slide-in" style="animation-delay: 0.3;">
            <div class="categories-box">
                <a href="Search.php?category=clinic" class="category">
                    <img src="image/Clinic-icon.png" alt="Clinic">
                    <span>Clinic</span>
                </a>
                <a href="Search.php?category=pharmacy" class="category">
                    <img src="image/pharmacy-icon.png">
                    <span>Pharmacy</span>
                </a>
            </div>
        </div>

        <div class="mapAyerKeroh slide-in" style="animation-delay:0.4s;">
            <div id="map-container">
                <div id="loc-container">
                    <img src="image/marker-container.png" id="marker-image">
                    <div>
                        <div class="current-location">Melaka, Malaysia</div>
                        <div class="area-name">(Ayer Keroh)</div>
                    </div>
                </div>

                <div id="map"></div>
            </div>
        </div>
    </div>
    <?php include("footer.php") ?>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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
   <?php
    include("database.php");
    
    $sql = "SELECT clinicName AS name, latitude, longitude, 'clinic' AS type FROM clinic
            UNION
            SELECT pharmacyName AS name, latitude, longitude, 'pharmacy' AS type FROM pharmacy
            ";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $locations = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $locations[] = $row;
    }
    ?>
        <script>
            var clinicIcon = L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                iconSize: [40, 40],
            });

            var pharmacyIcon = L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
                iconSize: [40, 40],
            });
        var map = L.map('map').setView([2.271439, 102.286995], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var locations = <?php echo json_encode($locations); ?>;

        console.log("DB DATA:", locations);

        locations.forEach(loc => {
            if (loc.latitude && loc.longitude) {

                let locationtype = (loc.type === "pharmacy") ? "Pharmacy" : "Clinic";

                let iconType = (loc.type === "pharmacy") ? pharmacyIcon : clinicIcon;

                L.marker([parseFloat(loc.latitude), parseFloat(loc.longitude)], {
                    icon: iconType
                })
                .addTo(map)
                .bindPopup(loc.name + " (" + locationtype + ")");
            }
        });

        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        if (localStorage.getItem('theme')=== 'dark') {
            body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '☀️Light Mode'
        }
        </script>
</html>