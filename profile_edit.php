<?php
session_start();

include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Redirect to a login page or handle the situation where the user is not logged in
    header("Location: login.php");
    exit();
}

$pageTitle = "Profile Edit"; // Set the page title for the index page

// Check if the user is logged in
if (isset($_SESSION["UID"])) {
    $userId = $_SESSION["UID"];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT u.matricNo, u.userEmail, p.username, p.program, p.mentor, p.motto, p.profile_photo, p.phone_number, p.state_of_origin, p.home_address, p.intake_batch
                            FROM user u
                            JOIN profile p ON u.userID = p.userID
                            WHERE u.userID = ?
                            LIMIT 1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $matricNo = $row["matricNo"];
            $userEmail = $row["userEmail"];
            $username = $row["username"];
            $program = $row["program"];
            $mentor = $row["mentor"];
            $motto = $row["motto"];
            $profile_photo = $row["profile_photo"];
            $phone_number = $row["phone_number"];
            $state_of_origin = $row["state_of_origin"];
            $home_address = $row["home_address"];
            $intake_batch = $row["intake_batch"];
        } else {
            // Handle the case where no user data is found
            $error = "User data not found";
        }
    } else {
        // Handle the case where the query has an error
        $error = "Error in SQL query: " . mysqli_error($conn);
    }

    $content = '
        <div class="card mx-auto mx-md-5 text-center text-md-start rounded-3 details-card shadow">
            <div class="row g-0">
                <div class="col-md-5 col-lg-2 d-flex align-items-center justify-content-center text-center">
                    <img id="profileImage" src="profile_photos/' . ($profile_photo !== 'cute.jpg' ? $profile_photo : 'cute.jpg') . '" class="img-fluid rounded-3 image-card-shadow" alt="Profile Photo">
                </div>
                <div class="col-md-6 col-lg-10">
                    <div class="card-body details-card-body">
                        <div class="d-flex justify-content-end">
                            <span class="badge rounded-3 btn-primary"><a href="profile_edit.php" class="text-white">Edit</a></span>
                        </div>
                        <form id="profile" action="profile_editting.php" method="post" enctype="multipart/form-data">
                            <h5 class="card-title display-7 fw-bold">Student Details</h5>
                            <input type="hidden" name="current_profile_photo" value="' . $profile_photo . '">
                            <table class="table table-light table-hover">
                                <tbody>
                                    <tr>
                                        <td>Matric No:</td>
                                        <td class="w-75">' . $matricNo . '</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td class="w-75">' . $userEmail . '</td>
                                    </tr>
                                    <tr>
                                        <td>Name:</td>
                                        <td class="w-75"><input type="text" id="username" name="username" size="90" value="' . $username . '"></td>
                                    </tr>
                                    <tr>
                                        <td>Program:</td>
                                        <td class="w-75">
                                            <select size="1" id="program" name="program">
                                                <option value="" ' . (($program == '') ? ' selected' : '') . ' disabled>Select Program</option>
                                                <option ' . (($program == 'Software Engineering') ? 'selected' : '') . '>Software Engineering</option>
                                                <option ' . (($program == 'Network Engineering') ? 'selected' : '') . '>Network Engineering</option>
                                                <option ' . (($program == 'Data Science') ? 'selected' : '') . '>Data Science</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Phone No:</td>
                                        <td class="w-75"><input type="text" id="phone_number" name="phone_number" size="30" value="' . $phone_number . '"></td>
                                    </tr>
                                    <tr>
                                        <td>State of Origin:</td>
                                        <td class="w-75"><input type="text" id="state_of_origin" name="state_of_origin" size="50" value="' . $state_of_origin . '"></td>
                                    </tr>
                                    <tr>
                                        <td>Mentor Name:</td>
                                        <td class="w-75"><input type="text" id="mentor" name="mentor" size="90" value="'. $mentor .'"></td>
                                    </tr>
                                    <tr>
                                        <td>Home Address:</td>
                                        <td class="w-75"><input type="text" id="home_address" name="home_address" size="90" value="'. $home_address .'"></td>
                                    </tr>
                                    <tr>
                                        <td>Intake Batch:</td>
                                        <td class="w-75"><input type="number" id="intake_batch" name="intake_batch" size="90" value="<?php echo $intake_batch; ?>" placeholder="Enter the intake year"></td>
                                    </tr>
                                    <tr>
                                        <td>Profile Photo:</td>
                                        <td class="w-75">
                                            <input type="file" name="new_profile_photo">
                                        </td>
                                    </tr>
                                </table>
                                <h5 class="card-title display-7 fw-bold">My Study Motto</h5>
                                <table class="table table-light table-hover">
                                    <tbody>
                                        <tr>
                                            <td><textarea rows="2" id="motto" name="motto" style="width:100%">' . $motto . '</textarea></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="text-align: right; padding-bottom:5px;">
                                    <input class="btn-primary rounded-3" type="submit" value="Update"> <input class="btn-primary rounded-3" type="reset"  value="Reset" onclick="resetForm()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';

    include 'template.php';

} else {
    // Handle the case where the user is not logged in
    $error = "User not logged in";

    header("Location: login.php");
    exit();
}
?>
