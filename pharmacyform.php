<?php
session_start();
include 'database.php';

$editMode = false;
$pharmacy = [
    'pharmacyId' => '', 'pharmacyName' => '', 'product' => '',
    'message' => '', 'address' => '', 'latitude' => '', 'longitude' => '',
    'phoneNum' => '', 'opHours' => ''
];

if (isset($_GET['id'])) {
    $editMode = true;
    $id = (int) $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM pharmacy WHERE pharmacyId = $id");
    if ($row = mysqli_fetch_assoc($res)) {
        $pharmacy = $row;
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['pharmacyName']);
    $product = mysqli_real_escape_string($conn, $_POST['product']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
    $phoneNum = mysqli_real_escape_string($conn, $_POST['phoneNum']);
    $opHours = mysqli_real_escape_string($conn, $_POST['opHours']);

    if (!is_numeric($latitude) || !is_numeric($longitude)) {
        $error = "Latitude and longitude must be numbers.";
    } else if (isset($_POST['pharmacyId']) && $_POST['pharmacyId'] !== '') {
        $id = (int) $_POST['pharmacyId'];
        $sql = "UPDATE pharmacy SET
                    pharmacyName='$name', product='$product', message='$message',
                    address='$address', latitude='$latitude', longitude='$longitude',
                    phoneNum='$phoneNum', opHours='$opHours'
                WHERE pharmacyId = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: managepharmacy.php");
            exit();
        } else {
            $error = "Update failed: " . mysqli_error($conn);
        }
    } else {
        $sql = "INSERT INTO pharmacy
                    (pharmacyName, product, message, address, latitude, longitude, phoneNum, opHours)
                VALUES
                    ('$name', '$product', '$message', '$address', '$latitude', '$longitude', '$phoneNum', '$opHours')";
        if (mysqli_query($conn, $sql)) {
            header("Location: managepharmacy.php");
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
    <title><?php echo $editMode ? 'Edit Pharmacy' : 'Add Pharmacy'; ?></title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav class="admin-nav">
        <div class="admin-nav-title">MediLocator Admin</div>
        <div class="admin-nav-links">
            <a href="admindashboard.php">Dashboard</a>
            <a href="manageusers.php">Users</a>
            <a href="manageclinic.php">Clinics</a>
            <a href="managepharmacy.php" class="active">Pharmacies</a>
            <a href="manageappointment.php">Appointments</a>
            <a href="adminlogout.php" style="color:#ffb3b3;">Log out</a>
        </div>
    </nav>

    <div class="admin-content">
        <h1><?php echo $editMode ? 'Edit Pharmacy' : 'Add Pharmacy'; ?></h1>

        <?php if ($error): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" class="admin-form">
            <input type="hidden" name="pharmacyId" value="<?php echo htmlspecialchars($pharmacy['pharmacyId']); ?>">

            <label>Pharmacy Name</label>
            <input type="text" name="pharmacyName" value="<?php echo htmlspecialchars($pharmacy['pharmacyName']); ?>" required>

            <label>Product</label>
            <input type="text" name="product" value="<?php echo htmlspecialchars($pharmacy['product']); ?>">

            <label>Message</label>
            <textarea name="message"><?php echo htmlspecialchars($pharmacy['message']); ?></textarea>

            <label>Address</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($pharmacy['address']); ?>" required>

            <label>Latitude</label>
            <input type="text" name="latitude" value="<?php echo htmlspecialchars($pharmacy['latitude']); ?>" required>

            <label>Longitude</label>
            <input type="text" name="longitude" value="<?php echo htmlspecialchars($pharmacy['longitude']); ?>" required>

            <label>Phone Number</label>
            <input type="text" name="phoneNum" value="<?php echo htmlspecialchars($pharmacy['phoneNum']); ?>" required>

            <label>Operating Hours</label>
            <input type="text" name="opHours" value="<?php echo htmlspecialchars($pharmacy['opHours']); ?>" required>

            <div class="form-actions">
                <button type="submit" class="btn-add"><?php echo $editMode ? 'Save Changes' : 'Add Pharmacy'; ?></button>
                <a href="managepharmacy.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>