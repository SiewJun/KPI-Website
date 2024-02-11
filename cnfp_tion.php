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

// Obtain the user ID from the session
$userID = $_SESSION['UID'];

// CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addChallenge'])) {
        // Add new challenge
        $semYearInput = $_POST['semYear'];

        // Extract numeric values for semester and year
        preg_match('/Year (\d{1,})\/Sem (\d{1,})/', $semYearInput, $matches);
        $year = $matches[1];
        $semester = $matches[2];

        $challenge = $_POST['challenge'];
        $plan = $_POST['plan'];
        $remark = $_POST['remark'];

        $stmt = $conn->prepare("INSERT INTO challenges (semYear, challenge, plan, remark, userID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $semYearInput, $challenge, $plan, $remark, $userID);
        $stmt->execute();

        // Redirect after adding challenge
        header("Location: cnfp.php");
        exit();
    } elseif (isset($_POST['deleteChallenge'])) {
        // Delete challenge
        $ch_id = $_POST['deleteChallenge'];
        $stmt = $conn->prepare("DELETE FROM challenges WHERE ch_id = ?");
        $stmt->bind_param("i", $ch_id);
        $stmt->execute();

        // Redirect after deleting challenge
        header("Location: cnfp.php");
        exit();
    } elseif (isset($_POST['updateChallenge'])) {
      // Update challenge
      $ch_id = $_POST['editChallenge'];
      $semYearInput = $_POST['semYear'];
      // ... (Extract year, semester, and other details similar to adding challenge)

      $stmt = $conn->prepare("UPDATE challenges SET semYear = ?, challenge = ?, plan = ?, remark = ? WHERE ch_id = ?");
      $stmt->bind_param("ssssi", $semYearInput, $_POST['challenge'], $_POST['plan'], $_POST['remark'], $ch_id);
      $stmt->execute();

      // Redirect after updating challenge
      header("Location: cnfp.php");
      exit();
  }
}

// Fetch challenges from the database
$result = $conn->query("SELECT * FROM challenges WHERE userID = {$_SESSION['UID']} ORDER BY semYear ASC");
$challenges = [];
while ($row = $result->fetch_assoc()) {
    $challenges[] = $row;
}

// Close connection
$conn->close();

?>
