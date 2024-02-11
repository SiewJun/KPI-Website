<?php
include("config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Redirect to a login page or handle the situation where the user is not logged in
    header("Location: login.php");
    exit();
}

// Check if activityID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: activities.php");
    exit();
}

$activityID = $_GET['id'];
$userID = $_SESSION['UID'];

// Fetch activity details
$stmt = $conn->prepare("SELECT * FROM activities WHERE activityID = ? AND userID = ?");
$stmt->bind_param("ii", $activityID, $userID);
$stmt->execute();
$result = $stmt->get_result();
$activity = $result->fetch_assoc();

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    Edit Activity
  </title>
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="login-background">
    <!-- Body content for individual pages -->
    <div class="container mt-3">
        <!-- Edit activity form -->
        <form method="post" action="activities_tion.php">
            <input type="hidden" name="editActivity" value="<?php echo $activityID; ?>">
            <div class="form-group">
                <label for="semYear">Year & Sem:</label>
                <input type="text" class="form-control" name="semYear" required pattern="Year \d{1,}/Sem \d{1,}"
                    value="<?php echo $activity['semYear']; ?>">
            </div>
            <div class="form-group">
                <label for="activityName">Activity Name:</label>
                <input type="text" class="form-control" name="activityName" required
                    value="<?php echo $activity['activityName']; ?>">
            </div>
            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <input type="text" class="form-control" name="remarks" value="<?php echo $activity['remarks']; ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-3" name="updateActivity">Update Activity</button>
        </form>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
