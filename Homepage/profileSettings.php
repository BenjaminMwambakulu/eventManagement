<?php
session_start();
$conn = new mysqli("localhost", "root", "", "unievent_master");

if (isset($_SESSION['username'])) {
    $sql_get_profile = "SELECT profile_pic FROM users WHERE id='" . $_SESSION['user_id'] . "'";
    $result = $conn->query($sql_get_profile);
    $row = $result->fetch_assoc();
    $profile_pic = $row['profile_pic'];
} else {
    $profile_pic = "../images/mdi--user.svg";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/profileSettings.css">
    <script src="../script.js"></script>
    <title>UniEvent Master</title>
</head>

<body>
    <nav>
        <div class="logo">
            <img src="../images/microphone.png" alt="Logo" />
            <span>UniEvent Master</span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="./eventDiscovery.php">Upcoming Events</a></li>
            <li><a href="./eventArchive.php">Event Archive</a></li>
            <li><a href="organizeRequest.php">Organize Request</a></li>
            <li><a href="./contactUs.php">Contact Us</a></li>
        </ul>
        <?php if (isset($_SESSION['username'])) : ?>
            <div class="userProfile" style="display:flex; position: relative;">
                <a href="./userBoard.php">
                    <span><?php echo $_SESSION['username']; ?></span>
                    <img src=" <?php echo $profile_pic; ?>" alt="">
                </a>
            </div>
        <?php endif; ?>

        <div class="buttons" style="<?php echo isset($_SESSION['username']) ? 'display: none;' : ''; ?>">
            <a href="./organizerDash/eventRequests.php" class="login">Organizer Dashboard</a>
            <a href="../Dashboard/admin.php" class="login">Admin Dashboard</a>
            <a href="./signUp.html" class="register">Sign Up</a>
            <a href="./login.html" class="login">Log In</a>
        </div>
    </nav>

    <div class="dashboard-container" style="margin-top: 80px;">
        <div class="dashboard-header">
            <h2>Profile Settings</h2>
        </div>
        <section class="dashboard-section">
            <form id="user-settings-form" method="POST" action="../php/submit.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Update Profile Picture</legend>
                    <label for="profile-picture">Choose a picture:</label>
                    <input type="file" name="profile_picture" id="profile-picture" accept="image/*" required>
                </fieldset>
                <button type="submit" name="submitImage">Save Changes</button>
            </form>
            <form action="" method="" style="margin-top: 10px;">

                <fieldset>
                    <legend>Password Management</legend>
                    <label for="current-password">Current Password:</label>
                    <input type="password" id="current-password" name="current_password" required>

                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new_password" required>

                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>


                </fieldset>
                <button type="submit">Save Changes</button>
            </form>
        </section>
    </div>
</body>

</html>