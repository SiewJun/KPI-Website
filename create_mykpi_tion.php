<?php
include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = mysqli_real_escape_string($conn, $_SESSION['UID']);
    $indicatorId = mysqli_real_escape_string($conn, $_POST['indicator']);
    $studentAim = mysqli_real_escape_string($conn, $_POST['student_aim']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $value = mysqli_real_escape_string($conn, $_POST['value']);
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);

    $insertQuery = "INSERT INTO kpi_values (userID, kpi_id, student_aim, semester, year, value, remark, createdDate)
                    VALUES ('$userId', '$indicatorId', '$studentAim', '$semester', '$year', '$value', '$remark', current_timestamp())";
    
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: mykpi.php");
        exit();
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
} else {
    header("Location: mykpi.php");
    exit();
}
?>
