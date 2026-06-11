<?php if(isset($_GET['register_success'])): ?>
<script>
    alert("Account successfully created!");
</script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <img id="logo" src="image/MedilocatorIslam.svg">
    <div id="box">
        <h2>Hello.</h2>
        <p id="welcome">Welcome back!</p>

        <?php
        if(isset($_GET['error'])) {
            echo '<p style="color: red; text-align: center;"> Incorrect email or password!</p>';
        }
        if(isset($_GET['register_success'])) {
            echo '<p style="color: green; text-align: center;"> Registration successful! Please log in.</p>';
        }
        ?>

        <form action="login_process.php" method="POST">
            <div class="formGrp">
                <p style="text-align: left;">Email</p>
                <input type="text" name="email" id="emailIn" placeholder="✉ Enter email" style="text-align: left;" required>
            </div>
            <div class="formGrp">
                <p style="text-align: left;">Password</p>
                <input type="password" name="password" id="passIn" placeholder="🔒︎ Enter password" style="text-align: left;" required>
            </div>
            <a id="forgor" href="" style="text-align: right;" padding="20px" font-weight="bolder" color="atlantic";>Forgot password?</a>
            <button type="submit">Log in</button>
            <div id="noAcc">
                <p>Don't have an account? <a href="Register.php">Sign in</a> </p> 
            </div>
            
        </form>


    </div>
    <script>
        
    </script>
</body>
</html>