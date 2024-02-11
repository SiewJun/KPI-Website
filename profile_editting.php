<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Redirect to a login page or handle the situation where the user is not logged in
    header("Location: login.php");
    exit();
}

// Include the generateModalWithErrors function
function generateModalWithErrors($modalId, $modalTitle, $errors, $redirect = 'profile_edit.php')
{
    $redirectText = 'Edit Profile Again';

    // Concatenate errors into a string
    $errorString = implode("<br>", $errors);

    echo "
    <div class='modal' id='$modalId' tabindex='-1' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>$modalTitle (Errors)</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <p>$errorString</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick='window.location.href = \"$redirect\"'>$redirectText</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var $modalId = new bootstrap.Modal(document.getElementById('$modalId'));
        $modalId.show();
    </script>";
}

echo '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Include necessary Bootstrap CSS and JS files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>';

// This block is called when the Submit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $program = isset($_POST["program"]) ? mysqli_real_escape_string($conn, $_POST["program"]) : '';
    $mentor = mysqli_real_escape_string($conn, $_POST["mentor"]);
    $motto = mysqli_real_escape_string($conn, $_POST["motto"]);
    $currentProfilePhoto = mysqli_real_escape_string($conn, $_POST["current_profile_photo"]);
    $phone_number = mysqli_real_escape_string($conn, $_POST["phone_number"]);
    $state_of_origin = mysqli_real_escape_string($conn, $_POST["state_of_origin"]);
    $home_address = mysqli_real_escape_string($conn, $_POST["home_address"]);
    $intake_batch = mysqli_real_escape_string($conn, $_POST["intake_batch"]);

    // Assume that the userID is stored in a session variable named $_SESSION["UID"]
    $userID = $_SESSION["UID"];

    // Check if a new profile photo has been uploaded
    if (isset($_FILES["new_profile_photo"]) && $_FILES["new_profile_photo"]["error"] == 0) {
        $allowedFileTypes = array("jpg", "jpeg", "png", "gif");
        $originalFileName = $_FILES["new_profile_photo"]["name"];
        $newProfilePhoto = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

        // Check if the file type is allowed
        if (!in_array($newProfilePhoto, $allowedFileTypes)) {
            $errors = array("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
            $modalId = "errorModal";
            $modalTitle = "File Upload Error";
            generateModalWithErrors($modalId, $modalTitle, $errors, 'profile_edit.php');
            exit();
        }

        // Check if the file size is within the allowed limit (e.g., 2 MB)
        $maxFileSize = 5 * 1024 * 1024; // 2 MB
        if ($_FILES["new_profile_photo"]["size"] > $maxFileSize) {
            $errors = array("Error: File size exceeds the allowed limit (5 MB).");
            $modalId = "errorModal";
            $modalTitle = "File Upload Error";
            generateModalWithErrors($modalId, $modalTitle, $errors, 'profile_edit.php');
            exit();
        }

        // Upload the new photo to the server
        $uploadDir = "profile_photos/"; // Specify the directory to store uploaded photos
        $uploadPath = $uploadDir . $originalFileName;

        move_uploaded_file($_FILES["new_profile_photo"]["tmp_name"], $uploadPath);

        // Update the database with the new profile photo and additional fields
        $sql = "UPDATE profile SET username = ?, program = ?, mentor = ?, motto = ?, profile_photo = ?, phone_number = ?, state_of_origin = ?, home_address = ?, intake_batch = ? WHERE userID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssiss", $username, $program, $mentor, $motto, $originalFileName, $phone_number, $state_of_origin, $home_address, $intake_batch, $userID);
    } else {
        // If no new photo is uploaded, keep the existing photo and update additional fields
        $sql = "UPDATE profile SET username = ?, program = ?, mentor = ?, motto = ?, phone_number = ?, state_of_origin = ?, home_address = ?, intake_batch = ? WHERE userID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssiss", $username, $program, $mentor, $motto, $phone_number, $state_of_origin, $home_address, $intake_batch, $userID);
    }

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Form data updated successfully!<br>";
        header("location: index.php");
        exit();
    } else {
        $errors = array("Error: " . mysqli_error($conn));

        // Display error modal and go back to profile_edit.php
        $modalId = "errorModal";
        $modalTitle = "Update Error";
        generateModalWithErrors($modalId, $modalTitle, $errors, 'profile_edit.php');
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>