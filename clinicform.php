<?php
session_start();
include 'database.php';

$editMode = false;
$clinic = [
    'clinicId' => '', 
    'clinicName' => '', 
    'specialty' => '', 
    'specialServices' => '',
    'message' => '',
    'address' => '', 
    'latitude' => '', 
    'longitude' => '',
    'phoneNum' => '', 
    'opHourStart' => '',
    'opHourEnd' => '',
    'clinicImage' => ''
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
    $opHourStart = mysqli_real_escape_string($conn, $_POST['opHourStart']);
    $opHourEnd = mysqli_real_escape_string($conn, $_POST['opHourEnd']);
    $clinicImage = $clinic['clinicImage'] ?? '';

    if (isset($_FILES['clinicImage']) && $_FILES['clinicImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'image/';
        $fileName = basename($_FILES['clinicImage']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($fileExt, $allowedTypes)) {
            $newFileName = uniqid('clinic_', true) . '.' . $fileExt;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['clinicImage']['tmp_name'], $uploadPath)) {
                $clinicImage = $uploadPath;
            }
        } else {
            $error = "Only JPG, JPEG, PNG, GIF and WEBP images are allowed.";
        }
    }

    $clinicImage = mysqli_real_escape_string($conn, $clinicImage);

    if (!is_numeric($latitude) || !is_numeric($longitude)) {
        $error = "Latitude and longitude must be numbers.";
    } else if ($error == '' && isset($_POST['clinicId']) && $_POST['clinicId'] !== '') {
        // Update
        $id = (int) $_POST['clinicId'];
        $sql = "UPDATE clinic SET
                    clinicName='$name', specialty='$specialty', specialServices='$specialServices',
                    message='$message', address='$address', latitude='$latitude', longitude='$longitude',
                    phoneNum='$phoneNum', opHourStart='$opHourStart', opHourEnd='$opHourEnd', 
                    clinicImage='$clinicImage'
                WHERE clinicId = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: manageclinic.php");
            exit();
        } else {
            $error = "Update failed: " . mysqli_error($conn);
        }
    } else if ($error == '') {
        // Insert
        $result = mysqli_query($conn, "SELECT MAX(clinicId) AS maxId FROM clinic");
        $row = mysqli_fetch_assoc($result);
        $clinicId = ($row['maxId'] ?? 0) + 1;
        $sql = "INSERT INTO clinic
                    (clinicId, clinicName, specialty, specialServices, message, address, latitude, longitude, phoneNum, opHourStart, opHourEnd, clinicImage)
                VALUES
                    ('$clinicId', '$name', '$specialty', '$specialServices', '$message', '$address', '$latitude', '$longitude', '$phoneNum', '$opHourStart', '$opHourEnd', '$clinicImage')";
        echo "<pre>$sql</pre>";

        if (!mysqli_query($conn, $sql)) {
            die("MySQL Error: " . mysqli_error($conn));
        } else {
            echo "Insert successful!";
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editMode ? 'Edit Clinic' : 'Add Clinic'; ?></title>
    <link rel="stylesheet" href="adminMain.css">
    <link rel="stylesheet" href="clinicform.css">
</head>
<body>
    <div class = "container">
        <?php include("navbaradmin.php") ?>
    
    <div class="admin-content">
        <div class="admin-title">MediLocator Admin</div>
        <h1><?php echo $editMode ? 'Edit Clinic' : 'Add Clinic'; ?></h1>

        <?php if ($error): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" class="admin-form" enctype="multipart/form-data">
            <input type="hidden" name="clinicId" value="<?php echo htmlspecialchars($clinic['clinicId']); ?>">

            <label>Clinic Name</label>
            <input type="text" name="clinicName" value="<?php echo htmlspecialchars($clinic['clinicName']); ?>" required>

            <label>Specialty</label>
            <input type="text" name="specialty" value="<?php echo htmlspecialchars($clinic['specialty']); ?>" placeholder="Optional">

            <label>Special Services</label>
            <input type="text" name="specialServices" value="<?php echo htmlspecialchars($clinic['specialServices']); ?>" placeholder="Optional">

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

            <label>Operating Hour Start</label>
            <input type="time" name="opHourStart" value="<?php echo htmlspecialchars($clinic['opHourStart'] ?? ''); ?>" required>

            <label>Operating Hour End</label>
            <input type="time" name="opHourEnd" value="<?php echo htmlspecialchars($clinic['opHourEnd'] ?? ''); ?>" required>

            <label>Clinic Image</label>
            <input type="file" name="clinicImage" accept="image/*">

            <?php if (!empty($clinic['clinicImage'])): ?>
                <p class="current-image-text">Current Image:</p>
                <img src="<?php echo htmlspecialchars($clinic['clinicImage']); ?>" 
                    class="preview-image" 
                    alt="Clinic Image">
            <?php endif; ?>

            <div class="form-actions">
                <button type="submit" class="btn-add"><?php echo $editMode ? 'Save Changes' : 'Add Clinic'; ?></button>
                <a href="manageclinic.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
    </div>
    <?php include("footer.php") ?>
</body>
</html>