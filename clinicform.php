<?php
session_start();
include 'database.php';

$editMode = false;
$clinic = [
    'clinicId' => '', 'clinicName' => '', 'specialty' => '', 'specialServices' => '',
    'message' => '', 'address' => '', 'latitude' => '', 'longitude' => '',
    'phoneNum' => '', 'opHours' => '', 'clinicImage' => ''
];

if (isset($_GET['id'])) {
    $editMode = true;
    $id = (int) $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM clinic WHERE clinicId = $id");
    if ($row = mysqli_fetch_assoc($res)) {
        $clinic = $row;
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['clinicName']);
    $specialty = mysqli_real_escape_string($conn, $_POST['specialty']);
    $specialServices = mysqli_real_escape_string($conn, $_POST['specialServices']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
    $phoneNum = mysqli_real_escape_string($conn, $_POST['phoneNum']);
    $opHours = mysqli_real_escape_string($conn, $_POST['opHours']);
    $clinicImage = mysqli_real_escape_string($conn, $_POST['clinicImage']);

    if (!is_numeric($latitude) || !is_numeric($longitude)) {
        $error = "Latitude and longitude must be numbers.";
    } else if (isset($_POST['clinicId']) && $_POST['clinicId'] !== '') {
        // Update
        $id = (int) $_POST['clinicId'];
        $sql = "UPDATE clinic SET
                    clinicName='$name', specialty='$specialty', specialServices='$specialServices',
                    message='$message', address='$address', latitude='$latitude', longitude='$longitude',
                    phoneNum='$phoneNum', opHours='$opHours', clinicImage='$clinicImage'
                WHERE clinicId = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: manageclinic.php");
            exit();
        } else {
            $error = "Update failed: " . mysqli_error($conn);
        }
    } else {
        // Insert
        $sql = "INSERT INTO clinic
                    (clinicName, specialty, specialServices, message, address, latitude, longitude, phoneNum, opHours, clinicImage)
                VALUES
                    ('$name', '$specialty', '$specialServices', '$message', '$address', '$latitude', '$longitude', '$phoneNum', '$opHours', '$clinicImage')";
        if (mysqli_query($conn, $sql)) {
            header("Location: manageclinic.php");
            exit();
        } else {
            $error = "Insert failed: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editMode ? 'Edit Clinic' : 'Add Clinic'; ?></title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav class="admin-nav">
        <div class="admin-nav-title">MediLocator Admin</div>
        <div class="admin-nav-links">
            <a href="admindashboard.php">Dashboard</a>
            <a href="manageusers.php">Users</a>
            <a href="manageclinic.php" class="active">Clinics</a>
            <a href="managepharmacy.php">Pharmacies</a>
            <a href="manageappointment.php">Appointments</a>
            <a href="adminlogout.php" style="color:#ffb3b3;">Log out</a>
        </div>
    </nav>

    <div class="admin-content">
        <h1><?php echo $editMode ? 'Edit Clinic' : 'Add Clinic'; ?></h1>

        <?php if ($error): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" class="admin-form">
            <input type="hidden" name="clinicId" value="<?php echo htmlspecialchars($clinic['clinicId']); ?>">

            <label>Clinic Name</label>
            <input type="text" name="clinicName" value="<?php echo htmlspecialchars($clinic['clinicName']); ?>" required>

            <label>Specialty</label>
            <input type="text" name="specialty" value="<?php echo htmlspecialchars($clinic['specialty']); ?>">

            <label>Special Services</label>
            <input type="text" name="specialServices" value="<?php echo htmlspecialchars($clinic['specialServices']); ?>">

            <label>Message</label>
            <textarea name="message"><?php echo htmlspecialchars($clinic['message']); ?></textarea>

            <label>Address</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($clinic['address']); ?>" required>

            <label>Latitude</label>
            <input type="text" name="latitude" value="<?php echo htmlspecialchars($clinic['latitude']); ?>" required>

            <label>Longitude</label>
            <input type="text" name="longitude" value="<?php echo htmlspecialchars($clinic['longitude']); ?>" required>

            <label>Phone Number</label>
            <input type="text" name="phoneNum" value="<?php echo htmlspecialchars($clinic['phoneNum']); ?>" required>

            <label>Operating Hours</label>
            <input type="text" name="opHours" value="<?php echo htmlspecialchars($clinic['opHours']); ?>" required>

            <label>Image Path (e.g. image/clinic.jpg)</label>
            <input type="text" name="clinicImage" value="<?php echo htmlspecialchars($clinic['clinicImage']); ?>">

            <div class="form-actions">
                <button type="submit" class="btn-add"><?php echo $editMode ? 'Save Changes' : 'Add Clinic'; ?></button>
                <a href="manageclinic.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>