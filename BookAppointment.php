<?php
session_start();
include("database.php");

// example: get clinic id from URL
$clinicId = $_GET['id'] ?? 0;

$sql = "SELECT clinicName FROM clinic WHERE clinicId = $clinicId";
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
    <div class = "body-bg">
        <div id = "body-img">
        </div>
    </div>

    <div class = "container">
        <div class="appointment-page">

            <div class="top-bar">
                <h2>Book Appointment</h2>
                <p><?= htmlspecialchars($clinic['clinicName'] ?? 'Clinic') ?></p>
            </div>

            <div class="appointment-card">

                <div class="section">
                    <h3>Select Date</h3>
                    <input type="date" id="datePicker">
                </div>

                <div class="section">
                    <h3>Select Time</h3>

                    <div class="time-grid">
                        <button class="time-btn">10:00 AM</button>
                        <button class="time-btn active">11:00 AM</button>
                        <button class="time-btn">02:00 PM</button>
                        <button class="time-btn">03:00 PM</button>
                        <button class="time-btn">04:00 PM</button>
                        <button class="time-btn">05:00 PM</button>
                    </div>
                </div>

                <div class="section">
                    <select>
                        <option>General Checkup</option>
                        <option>Dental</option>
                        <option>X-Ray</option>
                        <option>Vaccination</option>
                    </select>
                </div>

                <button class="confirm-btn">
                    Confirm Booking
                </button>

            </div>
        </div>
    </div>

<?php include("footer.php"); ?>

<script>
const buttons = document.querySelectorAll(".time-btn");

buttons.forEach(btn => {
    btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
    });
});
</script>

</body>
</html>