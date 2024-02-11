<?php
session_start();
include("config.php");

$pageTitle = "Profile"; // Set the page title for the index page

// Check if the user is logged in
if (isset($_SESSION["UID"])) {
    $userId = $_SESSION["UID"];

    // Query to retrieve user and profile information for the logged-in user
    $sql = "SELECT u.matricNo, u.userEmail, p.username, p.program, p.mentor, p.motto, p.profile_photo, p.phone_number, p.state_of_origin, p.home_address, p.intake_batch
            FROM user u
            JOIN profile p ON u.userID = p.userID
            WHERE u.userID = $userId
            LIMIT 1";

    $result = mysqli_query($conn, $sql);

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

    // Generate content for the profile page
    $content = '
        <div class="card mx-auto mx-md-5 text-center text-md-start rounded-3 details-card shadow">
            <div class="row g-0">
                <div class="col-md-5 col-lg-2 d-flex align-items-center justify-content-center text-center">
                    <img id="profileImage" src="profile_photos/' . ($profile_photo !== 'cute.jpg' ? $profile_photo : 'cute.jpg') . '" class="img-fluid rounded-3 image-card-shadow" alt="Profile Photo">
                </div>
                <div class="col-md-6 col-lg-10">
                    <div class="card-body details-card-body">
                        <div class="d-flex justify-content-end">
                            <span class="badge rounded-pill bg-primary btn-primary"><a href="profile_edit.php"
                                    class="text-white">Edit</a></span>
                        </div>
                        <h5 class="card-title display-7 fw-bold">Student Details</h5>
                        <table class="table table-light table-hover">
                            <tbody>
                                <tr>
                                    <td>Name:</td>
                                    <td class="w-75">' . $username . '</td>
                                </tr>
                                <tr>
                                    <td>Matric No:</td>
                                    <td class="w-75">' . $matricNo . '</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td class="w-75">' . $userEmail . '</td>
                                </tr>
                                <tr>
                                    <td>Program:</td>
                                    <td class="w-75">' . $program . '</td>
                                </tr>
                                <tr>
                                    <td>Phone No:</td>
                                    <td class="w-75">' . $phone_number . '</td>
                                </tr>
                                <tr>
                                    <td>State of Origin:</td>
                                    <td class="w-75">' . $state_of_origin . '</td>
                                </tr>
                                <tr>
                                    <td>Mentor Name:</td>
                                    <td class="w-75">' . $mentor . ' </td>
                                </tr>
                                <tr>
                                    <td>Home Address:</td>
                                    <td class="w-75">' . $home_address . '</td>
                                </tr>
                                <tr>
                                    <td>Intake Batch:</td>
                                    <td class="w-75">' . $intake_batch . '</td>
                                </tr>
                            </tbody>
                        </table>
                        <h5 class="card-title display-7 fw-bold">My Study Motto</h5>
                        <table class="table table-light table-hover">
                            <tbody>
                                <tr>
                                    <td>' . ($motto == "" ? "&nbsp;" : $motto) . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    ';

    // Include the template to display the entire page
    include 'template.php';

} else {
    header("location: login.php");
    exit();
}
?>
