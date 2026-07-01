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
                // Jika user belum pernah upload gambar, guna gambar default
                // Pastikan awak letak gambar bernama "default.png" dalam folder ProfilePic
                $_SESSION['user-img'] = 'ProfilePic/default.png'; 
            }

            if ($user['role'] == 'admin') {
                header("Location: admindashboard.php");
                exit();
            } else {
                header("Location: HomeScreen.php");
                exit();
            }

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
?>