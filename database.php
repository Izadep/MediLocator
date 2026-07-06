<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medilocator";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn) {
    die("Database connection failed: ". mysqli_connect_errno());
}

mysqli_set_charset($conn, "utf8");