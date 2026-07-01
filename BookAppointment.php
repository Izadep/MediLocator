<?php
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $time = $_POST["time"] ?? '';
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

    $idQuery = "SELECT COUNT(*) AS total FROM appointment";
    $idResult = mysqli_query($conn, $idQuery);
    $idRow = mysqli_fetch_assoc($idResult);

    $appointmentId = "APT" . str_pad($idRow['total'] + 1, 3, "0", STR_PAD_LEFT);
    $check = "SELECT * FROM appointment 
          WHERE clinicId = $clinicId 
          AND dateTime = '$dateTime'";

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

$sql = "SELECT clinicName, specialty FROM clinic WHERE clinicId = $clinicId";
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

                    <div class="time-grid">
                        <input type="hidden" name="time" id="selectedTime" required>
                        <button type="button" class="time-btn" data-time="10:00:00">10:00 AM</button>
                        <button type="button" class="time-btn" data-time="11:00:00">11:00 AM</button>
                        <button type="button" class="time-btn" data-time="14:00:00">02:00 PM</button>
                        <button type="button" class="time-btn" data-time="15:00:00">03:00 PM</button>
                        <button type="button" class="time-btn" data-time="16:00:00">04:00 PM</button>
                        <button type="button" class="time-btn" data-time="17:00:00">05:00 PM</button>
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
</script>

</body>
</html>