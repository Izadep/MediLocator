<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Screen</title>
    <link rel= "stylesheet" href="HomeScreen.css">
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
                    <button class="dropbtn nav-item">Profile ▼</button>
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

                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3986.6844052725155!2d102.28686109116023!3d2.271083557748551!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sgl!2smy!4v1781063671548!5m2!1sen!2sus"
                    id="map" allowfullscreen loading="lazy"></iframe>
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
</body>
</html>