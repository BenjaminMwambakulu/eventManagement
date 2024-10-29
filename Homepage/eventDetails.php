<?php
session_start();
// Database connection
$serverName = "localhost";
$username = "root";
$password = "";
$dbname = "unievent_master";

$conn = new mysqli($serverName, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$posterPath = '';
$row = [];
$isRegistered = false;

// Get the event ID and type from the URL
if (isset($_GET['event_id']) && (isset($_GET['from']) && ($_GET['from'] == 'upComingEventDetail' || $_GET['from'] == 'archivedEventDetail'))) {
    $event_id = $_GET['event_id'];
    $eventType = $_GET['from'] == 'upComingEventDetail' ? 'approved_events' : 'archived_events';

    $sql = "SELECT * FROM $eventType WHERE id = $event_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $posterPath = '../uploads/' . $row['event_poster'];

        if (isset($_SESSION['user_id'])) {
            $logged_in_user_id = $_SESSION['user_id'];
            $check_registration_sql = "SELECT * FROM event_registrations WHERE user_id = $logged_in_user_id AND event_id = $event_id";
            $check_result = $conn->query($check_registration_sql);

            if ($check_result->num_rows > 0) {
                $isRegistered = true;
            }
        }
    } else {
        echo "Event not found.";
        exit;
    }
} else {
    echo "Invalid event ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    if (!$isRegistered && $eventType == 'approved_events') {
        $register_sql = "INSERT INTO event_registrations (user_id, event_id) VALUES ($_SESSION[user_id], $event_id)";

        if ($conn->query($register_sql) === TRUE) {
            echo "<script>alert('You have successfully registered for the event!');</script>";
            $isRegistered = true;
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('You are already registered for this event or the event is archived.');</script>";
    }
}

$isArchived = ($eventType == 'archived_events');

// Fetch uploaded media for the event
$media_sql = "SELECT * FROM event_media WHERE event_id = $event_id";
$media_result = $conn->query($media_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/home.css" />
    <title>Event Registration</title>
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
            <li><a href="./eventArchive.php">Event Archive</a></li>
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
            <a href="./organizerDash/eventRequests.php" class="login">Organizer Dashboard</a>
            <a href="../Dashboard/admin.php" class="login">Admin Dashboard</a>
            <a href="./signUp.html" class="register">Sign Up</a>
            <a href="./login.html" class="login">Log In</a>
        </div>
    </nav>
    <!-- End of Navigation -->

    <!-- Event Details Section -->
    <section class="event-details">
        <div class="event-banner">
            <img src="<?php echo $posterPath; ?>" alt="Event Poster">
        </div>
        <div class="event-info">
            <div>
                <h1><?php echo $row['event_name']; ?></h1>
                <?php if (!$isArchived) { // Check if the event is not archived 
                ?>
                    <?php if (!$isRegistered) { ?>
                        <form method="POST" action="">
                            <button type="submit" name="register" class="register-btn">Register</button>
                        </form>
                    <?php } else { ?>
                        <button class="register-btn disabled" disabled>Already Registered</button>
                    <?php } ?>
                <?php } else { // Event is archived 
                ?>
                    <button class="register-btn disabled" disabled>Registration Closed</button>
                <?php } ?>
            </div>
            <p><?php echo $row['event_description']; ?></p>
            <p><strong>Event Venue:</strong> <?php echo $row['event_venue']; ?></p>
            <p><strong>Date:</strong> <?php echo $row['event_date']; ?></p>
            <p><strong>Time:</strong> <?php echo $row['start_time'] . " - " . $row['end_time']; ?></p>
            <p><strong>Price:</strong> <?php echo $row['event_price']; ?></p>
            <p><strong>Organizer:</strong> <?php echo "Placeholder Organizer"; ?></p>
            <p><strong>Contact:</strong> <?php echo "Placeholder Contact"; ?></p>
        </div>

        <!-- Media Section -->
        <div class="media-section">
            <h2>Uploaded Media</h2>
            <?php
            if ($media_result->num_rows > 0) {
                while ($media_row = $media_result->fetch_assoc()) {
                    $media_path = '../uploads/' . $media_row['media_path'];
                    $media_type = $media_row['media_type'];

                    if ($media_type == 'image') {
                        echo "<img src='$media_path' alt='Uploaded Image' width='25%'>";
                    } elseif ($media_type == 'video') {
                        echo "<video width='100%' controls>
                                <source src='$media_path' type='video/mp4'>
                                Your browser does not support the video tag.
                            </video>";
                    } else {
                        echo "<p>Other media type: $media_type</p>";
                    }
                }
            } else {
                echo "No uploaded media found.";
            }
            ?>
        </div>

        <!-- Feedback Section -->
        <div class="feedback-section">
            <h2>Feedback</h2>
            <?php
            // Fetch and display feedback
            $sql_get_feedback = "SELECT ef.feedback, u.username FROM event_feedback ef JOIN users u ON ef.user_id = u.id WHERE ef.event_id = $event_id";
            $result_get_feedback = $conn->query($sql_get_feedback);

            if ($result_get_feedback->num_rows > 0) {
                while ($row_get_feedback = $result_get_feedback->fetch_assoc()) {
                    echo "<div class='chat-bubble'>
                        <span>" . $row_get_feedback['username'] . "</span> 
                        <p>" . $row_get_feedback['feedback'] . "</p>
                      </div>";
                }
            } else {
                echo "No feedback yet.";
            }
            ?>
        </div>
    </section>
    <!-- Footer Section -->
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
    <!-- End of Footer Section -->
</body>

</html>