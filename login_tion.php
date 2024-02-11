<?php
session_start();
include("config.php");

function generateModal($modalId, $modalTitle, $modalBody, $redirect = 'register.php') {
    $redirectText = ($redirect === 'login.php') ? 'Login' : 'Register Again';

    echo "
    <div class='modal' id='$modalId' tabindex='-1' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>$modalTitle</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <p>$modalBody</p>
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricNo = mysqli_real_escape_string($conn, $_POST['matricNo']);

    $sql = "SELECT * FROM user WHERE matricNo=? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $matricNo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($_POST['userPassword'], $row['userPassword'])) {
            $_SESSION["UID"] = $row["userID"];
            $_SESSION["matricNo"] = $row["matricNo"];
            $_SESSION['loggedin_time'] = time();

            // Check if "Remember me" is checked
            if (isset($_POST['remember']) && $_POST['remember'] == 'remember-me') {
                // Set a cookie to remember the user
                setcookie('remember_user', $_POST['matricNo'], time() + 3600 * 24 * 30); // Remember the user for 30 days
            }

            header("location:index.php");
            exit();
        } else {
            generateModal("userXCorrectModal", "Incorrect Email or Password", "Login error, email and password do not match.", 'login.php');
        }
    } else {
        generateModal("userXExistsModal", "User Not Found", "Login error, user not found.", 'login.php');
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

?>
