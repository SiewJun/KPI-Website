<?php
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
    $userMatric = mysqli_real_escape_string($conn, $_POST['matricNo']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPassword = mysqli_real_escape_string($conn, $_POST['userPassword']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Validate matric number format (e.g., BIXXXXXXXX)
    if (!preg_match('/^BI\d{8}$/', $userMatric)) {
        generateModal("invalidMatricModal", "Invalid Matric Number", "Matric number must have the format BIXXXXXXXX (e.g., BI21110201)");
        die();
    }

    if ($userPassword !== $confirmPwd) {
        generateModal("passwordMismatchModal", "Password Mismatch", "Password and confirm password do not match. Please try again.");
        die();
    }

    $stmt = $conn->prepare("SELECT * FROM user WHERE userEmail=? OR matricNo=? LIMIT 1");
    $stmt->bind_param("ss", $userEmail, $userMatric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        generateModal("userExistsModal", "User already exists", "Error: User already exists. Please register with a different email or matric number.");
    } else {
        $pwdHash = password_hash($userPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO user (matricNo, userEmail, userPassword) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $userMatric, $userEmail, $pwdHash);

        if ($stmt->execute()) {
            $lastInsertedId = $stmt->insert_id;

            $stmt = $conn->prepare("INSERT INTO profile (userID, username, program, mentor, motto) VALUES (?, '', '', '', '')");
            $stmt->bind_param("i", $lastInsertedId);

            if ($stmt->execute()) {
                generateModal("successRegisterModal", "Account Registered Successfully", "New user record created successfully. Welcome <b>" . htmlspecialchars($userMatric) . "</b>", 'login.php');
            } else {
                echo "Error inserting profile record: " . $stmt->error;
            }
        } else {
            echo "Error inserting user record: " . $stmt->error;
        }
        $stmt->close();
    }
    mysqli_close($conn);
}

echo '</body></html>';
?>
