<?php
include("config.php");
session_start();

if (!isset($_SESSION['UID'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Create MyKPI Indicator";

$userId = mysqli_real_escape_string($conn, $_SESSION['UID']);

$indicatorsQuery = "SELECT * FROM kpi_indicators ORDER BY indicator_type";
$indicatorsResult = mysqli_query($conn, $indicatorsQuery);

$content = '';

$content .= '
  <div class="container mt-4">
    <h2>Create New KPI</h2>
    <form action="create_mykpi_tion.php" method="post">
      <label for="indicator">Select Indicator Type:</label>
      <select name="indicator" id="indicator" class="form-control" required>
        <option value="" disabled selected>Select Indicator Type</option>';
        while ($indicator = mysqli_fetch_assoc($indicatorsResult)) {
          $content .= '<option value="' . $indicator['kpi_id'] . '">' . $indicator['indicator_type'] . ' - ' . $indicator['indicator_name'] . '</option>';
        }
$content .= '</select>
      <label for="student_aim">Student\'s Aim:</label>
      <input type="text" name="student_aim" id="student_aim" class="form-control" placeholder="e.g. 3.67" required>

      <label for="semester">Semester:</label>
      <input type="number" name="semester" id="semester" class="form-control" placeholder="1 or 2" min="1" max="2" required>

      <label for="year">Year:</label>
      <input type="number" name="year" id="year" class="form-control" placeholder="1 to 4" min="1" max="4" required>

      <label for="value">Value:</label>
      <input type="text" name="value" id="value" class="form-control" placeholder="e.g. 4" required>

      <label for="remark">Remark:</label>
      <input type="text" name="remark" id="remark" class="form-control" placeholder="e.g. there\'s space for improvement" required>

      <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>
  </div>';

include 'template.php';
?>
