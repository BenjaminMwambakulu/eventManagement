<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "unievent_master");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/eventDiscovery.css">
    <title>Event Archive</title>
</head>

<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">
            <img src="../images/microphone.png" alt="Logo" />
            <span>UniEvent Master</span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="./eventDiscovery.php">Upcoming Events</a></li>
            <li><a href="./eventArchive.php" class="navActive">Event Archive</a></li>
            <li><a href="organizeRequest.php">Organize Request</a></li>
            <li><a href="./contactUs.php">Contact Us</a></li>
        </ul>
        <?php
        if (isset($_SESSION['username'])) {
            $sql_get_profile = "SELECT profile_pic FROM users WHERE id='" . $_SESSION['user_id'] . "'";
            $resultProfile = $conn->query($sql_get_profile);
            $rowProfile = $resultProfile->fetch_assoc();
            $profile_pic = $rowProfile['profile_pic'];
            echo "
            <div class='userProfile' style='display:flex;'>
                <a href='./userBoard.php'>
                    <span>" . $_SESSION['username'] . "</span>
                    <img src='$profile_pic' alt='Profile Picture' />
                </a>
            </div>";
        } ?>

        <div class="buttons" style="<?php echo isset($_SESSION['username']) ? 'display: none;' : ''; ?>">
            <a href="./signUp.html" class="register">Sign Up</a>
            <a href="./login.html" class="login">Log In</a>
        </div>
    </nav>
    <!-- End of Navigation -->
    <?php
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unievent_master";

    $conn = new mysqli($serverName, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch approved events from the database
    $sql = "SELECT id,event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster FROM archived_events";
    $result = $conn->query($sql);
    ?>

    <div class="card-container">
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="card">
                    <img src="<?php echo "../uploads/" . $row['event_poster']; ?>" alt="<?php echo $row['event_name']; ?>" class="card-img">
                    <div class="card-content">
                        <h2 style="margin-bottom:7px;"><?php echo $row['event_name']; ?></h2>
                        <p style="line-height: 1.5; color:#708090">
                            <strong>Date:</strong><?php echo $row['event_date']; ?><br>
                            <strong>Venue:</strong><?php echo $row['event_venue']; ?><br>
                            <strong>Description:</strong><?php echo $row['event_description']; ?><br>
                            <?php
                            echo '<a href="eventDetails.php?event_id=' . $row['id'] . '&from=archivedEventDetail" class="View-More">View More</a>';
                            ?>
                        </p>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>No events found.</p>";
        }
        $conn->close();
        ?>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section logo">
                <img src="../images/microphone.png" alt="Logo" />
                <span><a href="../Homepage/index.php">UniEvent Master</a></span>
            </div>
            <div class="footer-section links-section">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="#" class="footer-link">Home</a></li>
                    <li><a href="#" class="footer-link">Upcoming Events</a></li>
                    <li><a href="#" class="footer-link">Previous Events</a></li>
                    <li><a href="#" class="footer-link">Organize Request</a></li>
                    <li><a href="#" class="footer-link">About Us</a></li>
                </ul>
            </div>
            <div class="footer-section contact-section">
                <h4 class="footer-heading">Contact Info</h4>
                <p class="footer-contact">Email: eventMaster@gmail.com</p>
                <p class="footer-contact">Phone Number: (265) 885705304</p>
            </div>
        </div>
    </footer>
</body>

</html>