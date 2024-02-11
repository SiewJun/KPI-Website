<?php
include("config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Redirect to a login page or handle the situation where the user is not logged in
    header("Location: login.php");
    exit();
}

// Check if ch_id is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: cnfp.php");
    exit();
}

$ch_id = $_GET['id'];
$userID = $_SESSION['UID'];

// Fetch challenge details
$stmt = $conn->prepare("SELECT * FROM challenges WHERE ch_id = ? AND userID = ?");
$stmt->bind_param("ii", $ch_id, $userID);
$stmt->execute();
$result = $stmt->get_result();
$challenge = $result->fetch_assoc();

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    Edit Challenges and Future Plans
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
        <!-- Edit challenge form -->
        <form method="post" action="cnfp_tion.php">
            <input type="hidden" name="editChallenge" value="<?php echo $ch_id; ?>">
            <div class="form-group">
                <label for="semYear">Year & Sem:</label>
                <input type="text" class="form-control" name="semYear" required pattern="Year \d{1,}/Sem \d{1,}"
                    value="<?php echo $challenge['semYear']; ?>">
            </div>
            <div class="form-group">
                <label for="challenge">Challenges:</label>
                <input type="text" class="form-control" name="challenge" required
                    value="<?php echo $challenge['challenge']; ?>">
            </div>
            <div class="form-group">
                <label for="plan">Future Plans:</label>
                <input type="text" class="form-control" name="plan" required
                    value="<?php echo $challenge['plan']; ?>">
            </div>
            <div class="form-group">
                <label for="remark">Remarks:</label>
                <input type="text" class="form-control" name="remark" value="<?php echo $challenge['remark']; ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-3" name="updateChallenge">Update Challenge</button>
        </form>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
