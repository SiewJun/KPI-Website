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
    if (isset($_POST['addActivity'])) {
        // Add new activity
        $semYearInput = $_POST['semYear'];

        // Extract numeric values for semester and year
        preg_match('/Year (\d{1,})\/Sem (\d{1,})/', $semYearInput, $matches);
        $year = $matches[1];
        $semester = $matches[2];

        $activityName = $_POST['activityName'];
        $remarks = $_POST['remarks'];

        $stmt = $conn->prepare("INSERT INTO activities (semYear, activityName, remarks, userID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $semYearInput, $activityName, $remarks, $userID);
        $stmt->execute();

        // Redirect after adding activity
        header("Location: activities.php");
        exit();
    } elseif (isset($_POST['deleteActivity'])) {
        // Delete activity
        $activityID = $_POST['deleteActivity'];
        $stmt = $conn->prepare("DELETE FROM activities WHERE activityID = ?");
        $stmt->bind_param("i", $activityID);
        $stmt->execute();

        // Redirect after deleting activity
        header("Location: activities.php");
        exit();
    } elseif (isset($_POST['updateActivity'])) {
        // Update activity
        $activityID = $_POST['editActivity'];
        $semYearInput = $_POST['semYear'];
        // ... (Extract year, semester, and other details similar to adding activity)

        $stmt = $conn->prepare("UPDATE activities SET semYear = ?, activityName = ?, remarks = ? WHERE activityID = ?");
        $stmt->bind_param("sssi", $semYearInput, $_POST['activityName'], $_POST['remarks'], $activityID);
        $stmt->execute();

        // Redirect after updating activity
        header("Location: activities.php");
        exit();
    }
}

// Fetch activities from the database
$result = $conn->query("SELECT * FROM activities WHERE userID = {$_SESSION['UID']} ORDER BY semYear ASC");
$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[] = $row;
}

// Close connection
$conn->close();

?>