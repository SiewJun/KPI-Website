<?php

include("config.php");

// Start or resume a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Redirect to a login page or handle the situation where the user is not logged in
    header("Location: login.php");
    exit();
}

$pageTitle = "Activities"; // Set the page title for the page

// Fetch activities from the database
$result = $conn->query("SELECT * FROM activities WHERE userID = {$_SESSION['UID']} ORDER BY semYear ASC");
$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[] = $row;
}

// Content for activities.php
$content = '
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="activities_tion.php" class="mb-3">
                    <div class="form-group">
                        <label for="semYear">Year & Sem:</label>
                        <input type="text" class="form-control" name="semYear" required pattern="Year \d{1,}/Sem \d{1,}" placeholder="Year X/Sem X">
                    </div>
                    <div class="form-group">
                        <label for="activityName">Activity Name:</label>
                        <input type="text" class="form-control" name="activityName" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks:</label>
                        <input type="text" class="form-control" name="remarks">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" name="addActivity">Add Activity</button>
                </form>
            </div>
        </div>

        <!-- Activities table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-container table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sem & Year</th>
                                <th>Name of Activities/Club/Association/Competition</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
$no = 1;
// Inside the loop in activities.php
foreach ($activities as $activity) {
    $content .= '
      <tr>
          <td>' . $no++ . '</td>
          <td>' . $activity['semYear'] . '</td>
          <td>' . $activity['activityName'] . '</td>
          <td>' . $activity['remarks'] . '</td>
          <td>
              <a href="edit_activity.php?id=' . $activity['activityID'] . '" class="btn btn-warning">Edit</a>
              <form method="post" action="activities_tion.php" class="d-inline">
                  <input type="hidden" name="deleteActivity" value="' . $activity['activityID'] . '">
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
          </td>
      </tr>';
}

$content .= '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
';

// Include the template
include 'template.php';

// Close connection
$conn->close();

?>