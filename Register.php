<?php 
session_start();
include 'database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $ic = mysqli_real_escape_string($conn, $_POST['userid']);
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {

        // check email
        $emailcheck = "SELECT * FROM users WHERE email = '$email'";
        $emailResult = mysqli_query($conn, $emailcheck);

        if(mysqli_num_rows($emailResult) > 0) {
            $error = "Email is already registered!";
        } else {

            // generate user id
            $sql = "SELECT COUNT(*) as total FROM users";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            $userid = "USR" . str_pad($row['total'] + 1, 3, "0", STR_PAD_LEFT);

            // 🔐 HASH PASSWORD
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (userid, name, pass, email)
                    VALUES ('$userid', '$name', '$hashedPassword', '$email')";

            if(mysqli_query($conn, $sql)) {
                header("Location: Login.php?register_success=1");
                exit();
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
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

        <form method="POST" onsubmit="return validatePassword()">
            <div class="formGrp">
                <p style="text-align: left;">IC/Passport number</p>
                <input type="text" name="userid" id="idIn" placeholder="🪪IC/Passport Number" style="text-align: left;" required>
            </div>

            <div class="formGrp">
                <p style="text-align: left;">Username</p>
                <input type="text" name="username" id="idnameIn" placeholder="What should we call you?" style="text-align: left;" required>
            </div>

            <div class="formGrp">
                <p style="text-align: left;">Email</p>
                <input type="text" name="email" id="emailIn" placeholder="✉ Enter email" style="text-align: left;" required>
            </div>

            <div class="formGrp">
                <p style="text-align: left;">Password</p>
                <div class="input-wrapper">
                    <input type="password" name="password" id="passIn" placeholder="🔒︎ Enter password" style="text-align: left;" required>
                    <span class="toggle-pass" onclick="togglePass()">👁️</span>
                </div>
            </div>

            <div class="formGrp">
                <p style="text-align: left;">Confirm Password</p>
                <div class="input-wrapper">
                    <input type="password" name="confirm_password" id= "cpassIn" placeholder="🔒︎ Enter password again" style="text-align: left;" required>
                     <span class="toggle-pass" onclick="togglePass()">👁️</span>
                </div>
            </div>

        
            <button type="submit">Register</button>
            <div id="noAcc">
                <p>Already have an account? <a href="Login.php">Log in</a> </p> 
            </div>
            
        </form>


    </div>
    <script>
        function validatePassword() {
            let pswd = document.getElementById("passIn").value;
            let confpwsd = document.getElementById("cpassIn").value;

            if (pswd !== confpwsd) {
                alert("Password does not match!");
                return false;
            } else {
                return true;
            }
        }
        function togglePass() {
            var passIn = document.getElementById("passIn");
            var cpassIn= document.getElementById("cpassIn");
            var icon= document.querySelectorAll(".toggle-pass");

            if(passIn.type === "password") {
                passIn.type= "text";
                cpassIn.type= "text";

                icon.forEach(function(icon) {
                    icon.innerText="🙈";
                });
                
            }else {
                passIn.type= "password";
                cpassIn.type= "password";

                icon.forEach(function(icon) {
                    icon.innerText="👁️";
                });
            }
        }
    </script>
</body>
</html>