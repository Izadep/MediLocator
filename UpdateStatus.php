<?php
include("database.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $appointmentId = $_POST['appointmentId'];

    $sql = "UPDATE appointment 
            SET status = 'History' 
            WHERE appointmentId = '$appointmentId'";

    if (mysqli_query($conn, $sql)) {
        header("Location: Appointment.php");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>