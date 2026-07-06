<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['pass'])) {

            $_SESSION['user_id'] = $user['userId'];
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            if (!empty($user['picture'])) {
                $_SESSION['user-img'] = $user['picture'];
            } else {
                $_SESSION['user-img'] = 'image/ProfileEmpty.png';
            }

            if ($user['role'] == 'admin') {
                header("Location: admindashboard.php");
            } elseif ($user['role'] == 'clin') {
                header("Location: ClinicDashboard.php");
            } elseif ($user['role'] == 'phar') {
                header("Location: PharmacyDashboard.php");
            } elseif ($user['role'] == 'user') {
                header("Location: HomeScreen.php");
            } else {
                header("Location: Login.php?error=invalid_role");
            }
            exit();

        } else {
            header("Location: Login.php?error=wrong_password");
            exit();
        }

    } else {
        header("Location: Login.php?error=user_not_found");
        exit();
    }

} else {
    header("Location: Login.php");
    exit();
}

mysqli_close($conn);