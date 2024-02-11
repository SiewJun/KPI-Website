<?php
include("config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Redirect to a login page or handle the situation where the user is not logged in
    header("Location: login.php");
    exit();
}

$pageTitle = "MyKPI Indicators"; // Set the page title for the page

// Sanitize user input
$userId = mysqli_real_escape_string($conn, $_SESSION['UID']);

// Fetch data from the database
$query = "SELECT kpi_values.*, kpi_indicators.indicator_name, kpi_indicators.indicator_type, kpi_indicators.faculty_kpi
          FROM kpi_indicators
          LEFT JOIN kpi_values ON kpi_indicators.kpi_id = kpi_values.kpi_id
          AND kpi_values.userID = $userId
          ORDER BY 
            CASE kpi_indicators.indicator_type
                WHEN 'CGP' THEN 1
                WHEN 'Student Activities' THEN 2
                WHEN 'Competition' THEN 3
                WHEN 'Leadership' THEN 4
                WHEN 'Graduate Aim' THEN 5
                WHEN 'Professional Certification' THEN 6
                WHEN 'Employability' THEN 7
                WHEN 'Mobility Program' THEN 8
                ELSE 9
            END,
            CASE kpi_indicators.indicator_name
                WHEN 'Faculty Level' THEN 1
                WHEN 'University Level' THEN 2
                WHEN 'National Level' THEN 3
                WHEN 'International Level' THEN 4
                ELSE 5
            END,
            kpi_values.kpi_value_id ASC";

$result = mysqli_query($conn, $query);

// Initialize variables to track current indicator
$currentIndicatorType = '';
$currentIndicatorName = '';
$currentRow = null;

// Counter for NO
$counter = 1;

// Initialize $content
$content = '';

$content .= '
  <div class="container mt-4">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">NO</th>
            <th scope="col">INDICATOR TYPE</th>
            <th scope="col">INDICATOR NAME</th>
            <th scope="col">FACULTY\'S KPI</th>
            <th scope="col">LATEST STUDENT\'S AIM</th>
            <th scope="col">SEM 1/YEAR 1</th>
            <th scope="col">SEM 2/YEAR 1</th>
            <th scope="col">SEM 1/YEAR 2</th>
            <th scope="col">SEM 2/YEAR 2</th>
            <th scope="col">SEM 1/YEAR 3</th>
            <th scope="col">SEM 2/YEAR 3</th>
            <th scope="col">SEM 1/YEAR 4</th>
            <th scope="col">SEM 2/YEAR 4</th>
            <th scope="col">LATEST REMARK</th>
            <th scope="col">ACTIONS</th>
          </tr>
        </thead>
        <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['indicator_type'] !== $currentIndicatorType || $row['indicator_name'] !== $currentIndicatorName) {
        // Display the previous row if not the first row
        if ($currentRow !== null) {
            $content .= formatTableRow($currentRow, $counter);
            $counter++;
        }

        // Start a new row for the current indicator
        $currentIndicatorType = $row['indicator_type'];
        $currentIndicatorName = $row['indicator_name'];
        $currentRow = [
            'indicator_type' => $row['indicator_type'],
            'indicator_name' => $row['indicator_name'],
            'faculty_kpi' => $row['faculty_kpi'],
            'student_aim' => $row['student_aim'],
            'latest_remark' => $row['remark'],
            'sem1_year1' => '',
            'sem2_year1' => '',
            'sem1_year2' => '',
            'sem2_year2' => '',
            'sem1_year3' => '',
            'sem2_year3' => '',
            'sem1_year4' => '',
            'sem2_year4' => '',
            'kpi_value_id' => $row['kpi_value_id']
        ];
    } else {
        // Update the latest student aim and remark for the current indicator
        $currentRow['student_aim'] = $row['student_aim'];
        $currentRow['latest_remark'] = $row['remark'];
    }

    // Assign values to the corresponding semester and year
    $currentRow['sem' . $row['semester'] . '_year' . $row['year']] = $row['value'];
}

// Display the last row
if ($currentRow !== null) {
    $content .= formatTableRow($currentRow, $counter);
}

$content .= '</tbody></table></div></div>'; // Close the table and container
include 'template.php'; // Include the template file

// Function to format a table row
function formatTableRow($row, $counter) {
    return "
    <tr>
      <td>$counter</td>
      <td>{$row['indicator_type']}</td>
      <td>{$row['indicator_name']}</td>
      <td>{$row['faculty_kpi']}</td>
      <td>{$row['student_aim']}</td>
      <td>{$row['sem1_year1']}</td>
      <td>{$row['sem2_year1']}</td>
      <td>{$row['sem1_year2']}</td>
      <td>{$row['sem2_year2']}</td>
      <td>{$row['sem1_year3']}</td>
      <td>{$row['sem2_year3']}</td>
      <td>{$row['sem1_year4']}</td>
      <td>{$row['sem2_year4']}</td>
      <td>{$row['latest_remark']}</td>
      <td>
        <a href='create_mykpi.php' class='btn btn-success btn-sm'>Create</a>
        <a href='select_mykpi.php?id={$row['kpi_value_id']}' class='btn btn-warning btn-sm'>Edit</a>
        <a href='select_mykpi.php?id={$row['kpi_value_id']}' class='btn btn-danger btn-sm'>Delete</a>
      </td>
    </tr>";
}
?>
