<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Screen</title>
    <link rel= "stylesheet" href="HomeScreen.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
</head>
<body>

    <nav class="NavBar" id="navbar">
        <div class="nav-contain">
            <a href="HomeScreen.php" class="logo">
                <img src="image/MedilocatorIslam.svg" alt="MediLocator Logo">
            </a>

            <div class="nav-links">
                <a href="HomeScreen.php" class="nav-item active">Home</a>
                <a href="Appointment.php" class="nav-item">Appointment</a>
                <a href="Chat.php" class="nav-item">Chat</a>

                <div class="dropdown">
                    <a href="Profile.php" class="dropbtn nav-item">
                        Profile ▼
                    </a>
                    <div class="dropdown-content">
                        <a href="Profile.php">My Account</a>
                        <a href="logout.php" style="color: red;">Log out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

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
                <div class="category">
                    <img src="image/specialist-icon.png">
                    <span>Specialist</span>
                </div>
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

    <div class="footer">
        
        <p>&copy; 2026 MediLocator</p>
    </div>
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
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>

        var map = L.map('map').setView(
            [2.271439, 102.286995],
            16
        );

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);

        L.marker([2.27502176, 102.28871116])
        .addTo(map)
        .bindPopup("Poliklinik Perdana")
        .openPopup();

        L.marker([2.27145132, 102.28238960])
        .addTo(map)
        .bindPopup("Klinik Dr Ani")
        .openPopup();

        L.marker([2.26507030, 102.28394772])
        .addTo(map)
        .bindPopup("STI Friendly Clinic (Rafflesia) - KK Ayer Keroh")
        .openPopup();

        L.marker([2.26882529, 102.29398103])
        .addTo(map)
        .bindPopup("Poliklinik Wahidah Sdn Bhd")
        .openPopup();

        L.marker([2.26668899, 102.28379739])
        .addTo(map)
        .bindPopup("Ayer Keroh Dental Clinic")
        .openPopup();

        L.marker([2.27210416, 102.29080551])
        .addTo(map)
        .bindPopup("MediPulih Klinik")
        .openPopup();

        L.marker([2.27125805, 102.28038480])
        .addTo(map)
        .bindPopup("Bekam Care MITC")
        .openPopup();

        L.marker([2.25750322, 102.29143906])
        .addTo(map)
        .bindPopup("Poliklinik Piang & X Ray Sdn Bhd")
        .openPopup();
        
        L.marker([2.24794715, 102.29974780])
        .addTo(map)
        .bindPopup("KLINIK IMPIAN (CAWANGAN AYER KEROH)")
        .openPopup();
        
        L.marker([2.27970066, 102.27771968])
        .addTo(map)
        .bindPopup("Poliklinik Nazmir")
        .openPopup();
        
        L.marker([2.25357375, 102.27648202])
        .addTo(map)
        .bindPopup("KLINIK ANDA 24 JAM")
        .openPopup();
        
        L.marker([2.25186622, 102.28945800])
        .addTo(map)
        .bindPopup("MyFirst Klinik (Ayer Keroh) | Family Clinic | Occupational Health")
        .openPopup();
        
        L.marker([2.24490713, 102.29118617])
        .addTo(map)
        .bindPopup("POLIKLINIK ANNA AYER KEROH MELAKA")
        .openPopup();
        
        L.marker([2.25698357, 102.29144298])
        .addTo(map)
        .bindPopup("Klinik Hang Tuah (Ayer Keroh)")
        .openPopup();
        
        L.marker([2.25710177, 102.28401830])
        .addTo(map)
        .bindPopup("Klinik Safwa Ayer Keroh")
        .openPopup();
        
        L.marker([2.25386522, 102.29056752])
        .addTo(map)
        .bindPopup("KLINIK SUNITA SDN BHD")
        .openPopup();
        
        L.marker([2.25333965, 102.29065822])
        .addTo(map)
        .bindPopup("Careclinics Al-Amin Ayer Keroh")
        .openPopup();
        
        L.marker([2.25764540, 102.28178643])
        .addTo(map)
        .bindPopup("Klinik Adam Hawa (Ayer Keroh)")
        .openPopup();
        
        L.marker([2.26742650, 102.28468602])
        .addTo(map)
        .bindPopup("Ayer Keroh Health Clinic")
        .openPopup();
        
        L.marker([2.25611491, 102.29142353])
        .addTo(map)
        .bindPopup("Kelinik Ayer Keroh")
        .openPopup();
        
        L.marker([2.25378163, 102.29056707])
        .addTo(map)
        .bindPopup("Q&M Ayer Keroh - Ng Dental Surgery (Invisalign Braces Provider)")
        .openPopup();
        
        L.marker([2.25068552, 102.27648423])
        .addTo(map)
        .bindPopup("MRIC CLINIC")
        .openPopup();
        
        L.marker([2.26460354, 102.30612569])
        .addTo(map)
        .bindPopup("SONOBEE ULTRASOUND AYER KEROH")
        .openPopup();

        L.marker([2.25764132, 102.28413072])
        .addTo(map)
        .bindPopup("Klinik Veterinar Ayer Keroh Heights")
        .openPopup();

        L.marker([2.27241286, 102.28821828])
        .addTo(map)
        .bindPopup("Star Life Clinic TM")
        .openPopup();

        </script>
</body>
</html>