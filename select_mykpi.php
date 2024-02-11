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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission
    $selectedSemester = mysqli_real_escape_string($conn, $_POST['semester']);
    $selectedYear = mysqli_real_escape_string($conn, $_POST['year']);

    // Redirect to the page where the user can edit the selected semester and year
    header("Location: selected_mykpi.php?id={$userId}&semester={$selectedSemester}&year={$selectedYear}");
    exit();
}

$pageTitle = "Edit MyKPI"; // Set the page title for the page

// Fetch distinct semesters and years from kpi_values for the user
$queryDistinctSemestersYears = "SELECT DISTINCT semester, year FROM kpi_values WHERE userID = $userId";
$resultDistinctSemestersYears = mysqli_query($conn, $queryDistinctSemestersYears);

// Initialize $content
$content = '';

$content .= '
    <div class="container mt-4">
        <h2>Select Semester and Year to Edit or Delete</h2>
        <form method="post" action="" class="mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="semester" class="form-label">Select Semester:</label>
                    <select name="semester" id="semester" class="form-select" required>
                        <option value="">Select Semester</option>';
while ($rowDistinct = mysqli_fetch_assoc($resultDistinctSemestersYears)) {
    $content .= "<option value=\"{$rowDistinct['semester']}\">{$rowDistinct['semester']}</option>";
}
$content .= '</select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="year" class="form-label">Select Year:</label>
                    <select name="year" id="year" class="form-select" required>
                        <option value="">Select Year</option>';
mysqli_data_seek($resultDistinctSemestersYears, 0); // Reset result set pointer
while ($rowDistinct = mysqli_fetch_assoc($resultDistinctSemestersYears)) {
    $content .= "<option value=\"{$rowDistinct['year']}\">{$rowDistinct['year']}</option>";
}
$content .= '</select>
                </div>
            </div>

            <button type="submit" class="btn btn-warning btn-sm">Edit</button>
        </form>

        <form method="post" action="delete_mykpi_values.php">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="semesterToDelete" class="form-label">Select Semester to Delete:</label>
                    <select name="semesterToDelete" id="semesterToDelete" class="form-select" required>
                        <option value="">Select Semester</option>';
mysqli_data_seek($resultDistinctSemestersYears, 0); // Reset result set pointer
while ($rowDistinct = mysqli_fetch_assoc($resultDistinctSemestersYears)) {
    $content .= "<option value=\"{$rowDistinct['semester']}\">{$rowDistinct['semester']}</option>";
}
$content .= '</select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="yearToDelete" class="form-label">Select Year to Delete:</label>
                    <select name="yearToDelete" id="yearToDelete" class="form-select" required>
                        <option value="">Select Year</option>';
mysqli_data_seek($resultDistinctSemestersYears, 0); // Reset result set pointer
while ($rowDistinct = mysqli_fetch_assoc($resultDistinctSemestersYears)) {
    $content .= "<option value=\"{$rowDistinct['year']}\">{$rowDistinct['year']}</option>";
}
$content .= '</select>
                </div>
            </div>

            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </div>';

include 'template.php'; // Include the template file
?>