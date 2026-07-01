<?php
session_start();
include 'database.php';
include 'adminauth.php';

$editMode = false;
$pharmacy = [
    'pharmacyId' => '', 
    'pharmacyName' => '', 
    'product' => '',
    'message' => '', 
    'address' => '', 
    'latitude' => '', 
    'longitude' => '',
    'phoneNum' => '', 
    'opHourStart' => '',
    'opHourEnd' => '',
    'pharmacyImage' => ''
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
    $opHourStart = mysqli_real_escape_string($conn, $_POST['opHourStart']);
    $opHourEnd = mysqli_real_escape_string($conn, $_POST['opHourEnd']);
    $pharmacyImage = $pharmacy['pharmacyImage'] ?? '';

    if (isset($_FILES['pharmacyImage']) && $_FILES['pharmacyImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'image/';
        $fileName = basename($_FILES['pharmacyImage']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($fileExt, $allowedTypes)) {
            $newFileName = uniqid('pharmacy_', true) . '.' . $fileExt;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['pharmacyImage']['tmp_name'], $uploadPath)) {
                $pharmacyImage = $uploadPath;
            }
        } else {
            $error = "Only JPG, JPEG, PNG, GIF and WEBP images are allowed.";
        }
    }

    $pharmacyImage = mysqli_real_escape_string($conn, $pharmacyImage);

    if (!is_numeric($latitude) || !is_numeric($longitude)) {
        $error = "Latitude and longitude must be numbers.";
    } else if (isset($_POST['pharmacyId']) && $_POST['pharmacyId'] !== '') {
        $id = (int) $_POST['pharmacyId'];
        $sql = "UPDATE pharmacy SET
                    pharmacyName='$name', product='$product', message='$message',
                    address='$address', latitude='$latitude', longitude='$longitude',
                    phoneNum='$phoneNum', opHourStart='$opHourStart', opHourEnd='$opHourEnd', pharmacyImage='$pharmacyImage'
                WHERE pharmacyId = $id";

        if (mysqli_query($conn, $sql)) {
            header("Location: managepharmacy.php");
            exit();
        } else {
            $error = "Update failed: " . mysqli_error($conn);
        }

    } else if ($error == '') {
        $sql = "INSERT INTO pharmacy
                    (pharmacyName, product, message, address, latitude, longitude, phoneNum, opHourStart, opHourEnd, pharmacyImage)
                VALUES
                    ('$name', '$product', '$message', '$address', '$latitude', '$longitude', '$phoneNum', '$opHourStart', '$opHourEnd', '$pharmacyImage')";
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
    <link rel="stylesheet" href="adminMain.css">
    <link rel="stylesheet" href="healthcareform.css.css">
</head>

<body>
    <div class = "container">
        <?php include("navbaradmin.php") ?>

    <div class="admin-content">
        <h1><?php echo $editMode ? 'Edit Pharmacy' : 'Add Pharmacy'; ?></h1>

        <?php if ($error): ?>
           <p style="color:red;"><?php echo $error; ?></p>
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
            <input type="text" name="opHourStart" value="<?php echo htmlspecialchars($pharmacy['opHourStart']); ?>" required>
            <input type="text" name="opHourEnd" value="<?php echo htmlspecialchars($pharmacy['opHourEnd']); ?>" required>

            <label>Pharmacy Image</label>
            <input type="file" name="pharmacyImage" accept="image/*">

            <?php if (!empty($pharmacy['pharmacyImage'])): ?>
                <p class="current-image-text">Current Image:</p>
                <img src="<?php echo htmlspecialchars($pharmacy['pharmacyImage']); ?>" 
                    class="preview-image" 
                    alt="Pharmacy Image">
            <?php endif; ?>

            <div class="form-actions">
                <button type="submit" class="btn-add"><?php echo $editMode ? 'Save Changes' : 'Add Pharmacy'; ?></button>
                <a href="managepharmacy.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
    </div>
     <?php include("footer.php") ?>
</body>
</html>