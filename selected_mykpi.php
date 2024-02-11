<?php
include("config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Redirect to a login page or handle the situation where the user is not logged in
    header("Location: login.php");
    exit();
}

$pageTitle = "Edit MyKPI"; // Set the page title for the page

// Sanitize user input
$userId = mysqli_real_escape_string($conn, $_SESSION['UID']);
$selectedSemester = mysqli_real_escape_string($conn, $_GET['semester']);
$selectedYear = mysqli_real_escape_string($conn, $_GET['year']);

// Fetch the data for the selected semester and year
$query = "SELECT * FROM kpi_values WHERE userID = $userId AND semester = $selectedSemester AND year = $selectedYear";
$result = mysqli_query($conn, $query);

// Initialize $content
$content = '';

$content .= '
    <div class="container mt-4">
        <h2>Edit KPI Values</h2>';

// Check if there are records to edit
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $content .= '
        <form method="post" action="update_selected_mykpi.php">
            <input type="hidden" name="kpi_value_id" value="' . $row['kpi_value_id'] . '">

            <div class="mb-3">
                <label for="student_aim" class="form-label">Student Aim:</label>
                <input type="number" name="student_aim" id="student_aim" class="form-control" value="' . $row['student_aim'] . '">
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Value:</label>
                <input type="number" name="value" id="value" class="form-control" value="' . $row['value'] . '" required>
            </div>

            <div class="mb-3">
                <label for="remark" class="form-label">Remark:</label>
                <input type="text" name="remark" id="remark" class="form-control" value="' . $row['remark'] . '">
            </div>

            <button type="submit" class="btn btn-success btn-sm">Update</button>
        </form>';
} else {
    $content .= '<p class="alert alert-warning">No records found for the selected semester and year.</p>';
}

$content .= '
    </div>';

include 'template.php'; // Include the template file
?>
