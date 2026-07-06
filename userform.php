<?php
include 'adminauth.php';
include 'database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

        if (mysqli_num_rows($checkEmail) > 0) {
            $error = "Email already exists.";
        } else {
            // Generate new userId
            $result = mysqli_query($conn, "SELECT userId FROM users ORDER BY userId DESC LIMIT 1");

            if ($row = mysqli_fetch_assoc($result)) {
                $lastId = $row['userId'];
                $num = (int) substr($lastId, 3);
                $newNum = $num + 1;
                $userId = "USR" . str_pad($newNum, 3, "0", STR_PAD_LEFT);
            } else {
                $userId = "USR001";
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Role is fixed as admin
            $sql = "INSERT INTO users (userId, name, email, pass, role)
                    VALUES ('$userId', '$name', '$email', '$hashedPassword', 'admin')";

            if (mysqli_query($conn, $sql)) {
                header("Location: manageusers.php?added=admin");
                exit();
            } else {
                $error = "Add admin failed: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Admin</title>
    <link rel="stylesheet" href="adminMain.css">
    <link rel="stylesheet" href="healthcareform.css">
</head>
<body>
    <div class="container">
        <?php include("navbaradmin.php"); ?>

        <div class="admin-content">
            <div class="admin-title">MediLocator Admin</div>
            <h1>Add Admin</h1>

            <?php if ($error): ?>
                <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" class="admin-form" onsubmit="return validatePassword()">
                <label>Name</label>
                <input type="text" name="name" required>

                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="passIn" minlength="8" required>
                    <span class="toggle-pass" onclick="togglePass()">👁️</span>
                </div>

                <label>Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" name="confirm_password" id="cpassIn" minlength="8" required>
                    <span class="toggle-pass" onclick="togglePass()">👁️</span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-add">Add Admin</button>
                    <a href="manageusers.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script>
       function validatePassword() {
            let pswd = document.getElementById("passIn").value;
            let confpwsd = document.getElementById("cpassIn").value;

            if (pswd.length < 8) {
                alert("Password must be at least 8 characters.");
                return false;
            }

            if (pswd !== confpwsd) {
                alert("Password does not match!");
                return false;
            }

            return true;
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