<?php
session_start();
include("database.php");

if(!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}

$name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $target_dir = "ProfilePic/"; 
    $file_name = basename($_FILES["profile_picture"]["name"]);
    
    // Elakkan nama fail bertindih dengan tambah ID dan masa
    $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $new_file_name = "user_" . $userId . "_" . time() . "." . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    $uploadOk = 1;

    // Semak format gambar
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "<script>alert('Hanya format JPG, JPEG, PNG & GIF dibenarkan.');</script>";
        $uploadOk = 0;
    }

    // Jika tiada masalah, proses upload
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Update database table users, attribute picture
            $update_sql = "UPDATE users SET picture = '$target_file' WHERE userId = '$userId'"; 
            
            if (mysqli_query($conn, $update_sql)) {
                // Update session supaya gambar baru terus terpapar
                $_SESSION['user-img'] = $target_file;
                
                // Refresh page
                header("Location: profile.php");
                exit();
            } else {
                echo "<script>alert('Gagal kemaskini database.');</script>";
            }
        } else {
            echo "<script>alert('Gagal memuat naik gambar.');</script>";
        }
    }
}

$sql = "SELECT a.*, c.clinicName, c.address, c.clinicImage
        FROM appointment a
        JOIN clinic c ON a.clinicId = c.clinicId
        WHERE a.userId = '$userId'
        AND a.dateTime >= NOW()
        ORDER BY a.dateTime ASC
        LIMIT 1";

$result = mysqli_query($conn, $sql);

$appointment = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="Profile.css">
    <title>Profile</title>
</head>

<body>
    <?php include("navbar.php") ?>
    <div class="contentprofile">
        <div class="profile-container">

            <div class="profile-header slide-in">
                <div class="profile-pic-container">
                    <div class="profile-pic">
                        <img src="<?php echo $_SESSION['user-img'] ?>" alt="Profile Picture">
                    </div>
                    
                    <form action="profile.php" method="POST" enctype="multipart/form-data" id="upload-form">
                        <label for="profile_picture" class="edit-pic-btn">✏️</label>
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" style="display: none;" onchange="document.getElementById('upload-form').submit();">
                    </form>
                </div>
                <div class="profile-info">
                    <h2><?php echo $_SESSION['user_name']; ?></h2>
                    <p><?php echo $_SESSION['user_email']; ?></p>
                </div>
            </div>

            <div class="appointment-section slide-in" style="animation-delay: 0.1s;">
                <h2 class="section-title">My Appointments</h2>

                <div class="appointment-card">

                <?php if ($appointment): ?>

                    <?php
                    $clinicImage = $appointment['clinicImage'] ?? 'default.jpg';
                    $clinicImage = trim($clinicImage);
                    ?>

                    <div class="clinic-image"
                        style="background-image: url('<?php echo htmlspecialchars($clinicImage); ?>');">
                    </div>

                    <div class="appointment-info">
                        <span class="appointment-date">
                            <?= date("d M Y, h:i A", strtotime($appointment['dateTime'])) ?>
                        </span>

                        <div class="healthcare-type">Clinic</div>

                        <p class="healthcare-name">
                            <b><?= htmlspecialchars($appointment['clinicName']) ?></b>
                        </p>

                        <p class="clinic-address">
                            <?= htmlspecialchars($appointment['address']) ?>
                        </p>

                        <a href="Details.php?id=<?= $appointment['clinicId'] ?>&type=clinic" class="details-link">
                            VIEW DETAILS →
                        </a>
                    </div>

                <?php else: ?>

                    <p style="padding: 20px; color: #777;">
                        No upcoming appointment
                    </p>

                <?php endif; ?>

                <button class="go-btn" onclick="location.href='Appointment.php'">Go</button>
            </div>
            </div>

            <div class="profile-menu slide-in" style="animation-delay: 0.2s;">
                <a href="History.php">📅 Appointment History</a>
                <a href="#" id="darkModeToggle">🌙Dark Mode</a>
                <a href="logout.php" class="logout">🚪 Log Out</a>
            </div>
        </div>
   </div>

   <?php include("footer.php") ?>

    <script>
        window.addEventListener('scroll',function(){
            var navbar = document.getElementById('navbar');
            if(window.scrollY > 20) {
                navbar.classList.add('scrolled');
            }else{
                navbar.classList.remove('scrolled');
            }
        });
        
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
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

        darkModeToggle.addEventListener('click', function(e){
            e.preventDefault();
            body.classList.toggle('dark-mode');

            if(body.classList.contains('dark-mode')) {
                localStorage.setItem('theme','dark');
                darkModeToggle.innerHTML = '☀️Light Mode';
            } else {
                localStorage.setItem('theme','light');
                darkModeToggle.innerHTML='🌙 Dark Mode';
            }
        });
    </script>
</body>
</html>