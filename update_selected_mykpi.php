<?php
include("config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Redirect to a login page or handle the situation where the user is not logged in
    header("Location: login.php");
    exit();
}

// Sanitize user input
$userId = mysqli_real_escape_string($conn, $_SESSION['UID']);
$kpiValueId = mysqli_real_escape_string($conn, $_POST['kpi_value_id']);
$studentAim = mysqli_real_escape_string($conn, $_POST['student_aim']);
$value = mysqli_real_escape_string($conn, $_POST['value']);
$remark = mysqli_real_escape_string($conn, $_POST['remark']);

// Update the database
$query = "UPDATE kpi_values SET student_aim = '$studentAim', value = '$value', remark = '$remark' WHERE kpi_value_id = $kpiValueId AND userID = $userId";
$result = mysqli_query($conn, $query);

// Redirect to the page where users can view their KPI values
header("Location: mykpi.php");
exit();
?>
