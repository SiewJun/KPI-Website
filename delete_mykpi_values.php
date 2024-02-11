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
$selectedSemesterToDelete = mysqli_real_escape_string($conn, $_POST['semesterToDelete']);
$selectedYearToDelete = mysqli_real_escape_string($conn, $_POST['yearToDelete']);

// Delete the selected semester and year values from the database
$queryDeleteValues = "DELETE FROM kpi_values WHERE userID = $userId AND semester = $selectedSemesterToDelete AND year = $selectedYearToDelete";
$resultDeleteValues = mysqli_query($conn, $queryDeleteValues);

// Redirect to the page where users can select semesters and years
header("Location: mykpi.php");
exit();
?>
