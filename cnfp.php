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

$pageTitle = "Challenges and Future Plans"; // Set the page title for the index page

// Fetch activities from the database
$result = $conn->query("SELECT * FROM challenges WHERE userID = {$_SESSION['UID']} ORDER BY semYear ASC");
$challenges = [];
while ($row = $result->fetch_assoc()) {
    $challenges[] = $row;
}

// Content for cnfp.php
$content = '
    <div class="container mt-3 table_">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="cnfp_tion.php" class="mb-3">
                    <div class="form-group">
                        <label for="semYear">Year & Sem:</label>
                        <input type="text" class="form-control" name="semYear" required pattern="Year \d{1,}/Sem \d{1,}" placeholder="Year X/Sem X">
                    </div>
                    <div class="form-group">
                        <label for="challenge">Challenges:</label>
                        <input type="text" class="form-control" name="challenge" required>
                    </div>
                    <div class="form-group">
                        <label for="plan">Future Plans:</label>
                        <input type="text" class="form-control" name="plan" required>
                    </div>
                    <div class="form-group">
                        <label for="remark">Remarks:</label>
                        <input type="text" class="form-control" name="remark">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" name="addChallenge">Add Challenges</button>
                </form>
            </div>
        </div>

        <!-- challenges table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-container">
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Year & Sem</th>
                            <th>Challenges</th>
                            <th>Future Plans</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
$no = 1;
// Inside the loop for challenges
foreach ($challenges as $challenge) {
$content .= '
<tr>
  <td>' . $no++ . '</td>
  <td>' . $challenge['semYear'] . '</td>
  <td>' . $challenge['challenge'] . '</td>
  <td>' . $challenge['plan'] . '</td>
  <td>' . $challenge['remark'] . '</td>
  <td>
      <a href="edit_cnfp.php?id=' . $challenge['ch_id'] . '" class="btn btn-warning">Edit</a>
      <form method="post" action="cnfp_tion.php" class="d-inline">
          <input type="hidden" name="deleteChallenge" value="' . $challenge['ch_id'] . '">
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
</div>
';

// Include the template
include 'template.php';

// Close connection
$conn->close();

?>
