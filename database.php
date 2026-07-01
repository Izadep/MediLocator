<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medilocator";
$root = "3307";

$conn = mysqli_connect($servername,$username,$password,$dbname, $root, 8080);

if(!$conn) {
    die("Database connection failed: ". mysqli_connect_errno());
}

mysqli_set_charset($conn, "utf8");