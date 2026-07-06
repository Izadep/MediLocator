<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>
        alert('Please log in to book an appointment.');
        window.location.href = 'Login.php';
    </script>";
    exit();
}

include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $time = $_POST["time"] ?? '';

    if (empty($time)) {
    echo "<script>
        alert('Please select a time slot.');
        window.history.back();
    </script>";
    exit();
}


    $today = date("Y-m-d");
    $maxDate = date("Y-m-d", strtotime("+3 months"));

    if ($date < $today || $date > $maxDate) {
        echo "<script>
        alert('Invalid booking date. Must be within 3 months.');
        window.history.back();
        </script>";
        exit();
    }
    $type = mysqli_real_escape_string($conn, $_POST["type"]);

    $dateTime = $date . " " . $time;
    

    $userId = $_SESSION["user_id"];
    $clinicId = (int)$_GET['id'];

    $userCheck = "
    SELECT * FROM appointment
    WHERE userId = '$userId'
    AND dateTime = '$dateTime'
    AND status = 'Pending'
    ";

    $userResult = mysqli_query($conn, $userCheck);

        if (mysqli_num_rows($userResult) > 0) {
            echo "<script>
                alert('You already have an appointment at this time slot.');
                window.location.href = 'BookAppointment.php?id=$clinicId';
            </script>";
            exit();
        }

        

    $idQuery = "SELECT COUNT(*) AS total FROM appointment";
    $idResult = mysqli_query($conn, $idQuery);
    $idRow = mysqli_fetch_assoc($idResult);

    $appointmentId = "APT" . str_pad($idRow['total'] + 1, 3, "0", STR_PAD_LEFT);
    // Check if clinic slot already booked
    $check = "
        SELECT * FROM appointment 
        WHERE clinicId = $clinicId 
        AND dateTime = '$dateTime'
        AND status = 'Pending'
    ";

    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>
            alert('This time slot is already booked.');
            window.location.href = 'BookAppointment.php?id=$clinicId';
        </script>";
        exit();
    }
    
    $sql = "INSERT INTO appointment
            (appointmentId, dateTime, userId, clinicId, type)
            VALUES
            ('$appointmentId','$dateTime', '$userId', $clinicId, '$type')";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Appointment booked successfully!');</script>";
    } else {
        echo "<script>alert('Booking failed.');</script>";
    }
}

$clinicId = $_GET['id'] ?? 0;

$sql = "SELECT clinicName, specialty, specialServices, opHourStart, opHourEnd 
        FROM clinic 
        WHERE clinicId = $clinicId";
$result = mysqli_query($conn, $sql);
$clinic = mysqli_fetch_assoc($result);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>

    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="BookAppointment.css">
</head>
<body>
<?php include("navbar.php"); ?>
    <!--<div class = "body-bg">
        <div id = "body-img">
        </div>
    </div>-->

    <div class = "container">
        <div class="appointment-page">

            <div class="top-bar">
                <h2>Book Appointment</h2>
                <p><?= htmlspecialchars($clinic['clinicName'] ?? 'Clinic') ?></p>
            </div>
            <div class="appointment-card">
            <form action="BookAppointment.php?id=<?= $clinicId ?>" method="POST">

                <div class="section">
                    <h3>Select Date</h3>
                    <input type="date" id="datePicker" name="date" required>
                </div>

                <div class="section">
                    <h3>Select Time</h3>
                    <h5 class = "slot-note" >Available slots are based on the clinic's operating hours.</h5>


                    <div class="time-grid">
                        <input type="hidden" name="time" id="selectedTime" required>
                       <?php
                        $start = $clinic['opHourStart'] ?? '09:00:00';
                        $end = $clinic['opHourEnd'] ?? '17:00:00';

                        $openTime = strtotime($start);
                        $closeTime = strtotime($end);

                        $firstSlot = $openTime + (30 * 60);
                        $lastSlot = $closeTime - (60 * 60);

                        // First slot: 30 minutes after opening
                        $slotValue = date("H:i:s", $firstSlot);
                        $slotLabel = date("h:i A", $firstSlot);

                        echo '<button type="button" class="time-btn" data-time="' . $slotValue . '">'
                            . $slotLabel .
                            '</button>';

                        // Next slots: every full hour
                        $startHour = strtotime(date("Y-m-d H:00:00", $openTime)) + (60 * 60);

                        while ($startHour <= $lastSlot) {
                            $slotValue = date("H:i:s", $startHour);
                            $slotLabel = date("h:i A", $startHour);

                            echo '<button type="button" class="time-btn" data-time="' . $slotValue . '">'
                                . $slotLabel .
                                '</button>';

                            $startHour += 60 * 60;
                        }
                        ?>
                    </div>
                </div>

                <div class="section">
                    <h3>Appointment Type</h3>

                    <select name="type" required>
                        <option value="General Checkup">General Checkup</option>

                        <?php
                        $services = [];

                        if (!empty($clinic['specialty'])) {
                            $services[] = trim($clinic['specialty']);
                        }

                        if (!empty($clinic['specialServices'])) {
                            $services = array_merge(
                                $services,
                                array_map('trim', explode(',', $clinic['specialServices']))
                            );
                        }

                        $services = array_unique($services);

                        foreach ($services as $service) {
                            if (strcasecmp($service, "General Checkup") != 0) {
                                echo '<option value="' . htmlspecialchars($service) . '">'
                                    . htmlspecialchars($service) .
                                    '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="button-group">
                    <a href="javascript:void(0)" class="back-btn" onclick="window.history.back()">
                        ← Back
                    </a>

                    <button type="submit" class="confirm-btn">
                        Confirm Booking
                    </button>
                </div>

            </form>
            </div>
        </div>
    </div>

<?php include("footer.php"); ?>

<script>
    const buttons = document.querySelectorAll(".time-btn");
    const selectedTime = document.getElementById("selectedTime");

    buttons.forEach(btn => {
        btn.addEventListener("click", () => {

            buttons.forEach(b => b.classList.remove("active"));

            btn.classList.add("active");

            selectedTime.value = btn.dataset.time;
        });
    });
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

        if (localStorage.getItem('theme')=== 'dark') {
            body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '☀️Light Mode'
        }
</script>

</body>
</html>