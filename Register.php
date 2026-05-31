<?php 
session_start();
include 'database.php';

if($_SERVER['REQUEST_METHOD'] == ['POSt']) {
    $userid = mysqli_real_escape_string($conn, $_POST['userid']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $sql = "SELECT COUNT(*) as total FROM users";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        $userid = "USR" . str_pad($row['total'] + 1, 3, "0" ,STR_PAD_LEFT );
    }

    $sql = "INSERT INTO users (userid,name, pass, email)
            VALUE ('$userid','$name','$password','$email')";

    if (mysqli_query($conn,$sql)) {
        header("Location: Login.php?register_success=1");
        exit();
    }else {
        $error = "Registration failed:" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <img id="logo" src="image/MedilocatorIslam.svg">
    <div id="box">
        <h2>Sign Up</h2>
        <p id="welcome">Create new account!</p>

        <?php if (isset($error)):?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="formGrp">
                <p style="text-align: left;">IC/Passport number</p>
                <input type="text" name="userid" id="idIn" placeholder="🪪IC/Passport Number" style="text-align: left;" required>
            </div>

            <div class="formGrp">
                <p style="text-align: left;">Email</p>
                <input type="text" name="email" id="emailIn" placeholder="✉ Enter email" style="text-align: left;" required>
            </div>

            <div class="formGrp">
                <p style="text-align: left;">Password</p>
                <input type="password" name="password" id="passIn" placeholder="🔒︎ Enter password" style="text-align: left;" required>
            </div>

            <div class="formGrp">
                <p style="text-align: left;">Confirm Password</p>
                <input type="password" name="confirm_password" placeholder="🔒︎ Enter password again" style="text-align: left;" required>
            </div>

        
            <button type="submit">Register</button>
            <div id="noAcc">
                <p>Already have an account? <a href="Login.php">Log in</a> </p> 
            </div>
            
        </form>


    </div>
    <script>
        
    </script>
</body>
</html>