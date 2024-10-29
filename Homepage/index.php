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
    <link rel="stylesheet" href="../css/home.css">
    <script src="../script.js"></script>
    <title>UniEvent Master</title>
</head>

<body>
    <?php
    if (isset($_SESSION['successSignup']) && $_SESSION['msg_type'] == "success") {
        echo "<p class='success'>" . $_SESSION['successSignup'] . "</p>";
        unset($_SESSION['successSignup']);
    }
    if (isset($_SESSION['successLogin']) && $_SESSION['msg_type'] == "success") {
        echo "<p class='success'>" . $_SESSION['successLogin'] . "</p>";
        unset($_SESSION['successLogin']);
    }
    if (isset($_SESSION['message']) && $_SESSION['msg_type'] == "success") {
        echo "<p class='success'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>
    <div class="background">
        <!-- Navigation -->
        <nav>
            <div class="logo">
                <img src="../images/microphone.png" alt="Logo" />
                <span><a href="../Dashboard/admin.php" id="logoText">UniEvent Master</a></span>
            </div>
            <ul class="nav-links">
                <li><a href="index.php" class="navActive">Home</a></li>
                <li><a href="./eventDiscovery.php">Upcoming Events</a></li>
                <li><a href="./eventArchive.php">Event Archive</a></li>
                <li><a href="organizeRequest.php">Organize Request</a></li>
                <li><a href="./contactUs.php">Contact Us</a></li>
            </ul>
            <?php
            if (isset($_SESSION['username'])) {
                $sql_get_profile = "SELECT profile_pic FROM users WHERE id='" . $_SESSION['user_id'] . "'";
                $result = $conn->query($sql_get_profile);
                $row = $result->fetch_assoc();
                $profile_pic = $row['profile_pic'];
                echo "
        <div class='userProfile' style='display:flex;'>
            <a href='./userBoard.php'>
                <span>" . $_SESSION['username'] . "</span>
                <img src='$profile_pic' alt='Profile Picture' />
            </a>
            <a style='margin-left:10px;' href='logout.php' class='logout'>Log Out</a>
        </div>";
            } ?>

            <div class="buttons" style="<?php echo isset($_SESSION['username']) ? 'display: none;' : ''; ?>">
                <a href="./signUp.html" class="register">Sign Up</a>
                <a href="../Homepage/signInOpt.html" class="login">Log In</a>
            </div>
        </nav>
        <!-- End of Navigation -->
        <!-- Hero Section -->
        <section class="hero">
            <div class="content">
                <h1>Discover and Participate in University Events</h1>
                <p>
                    Stay informed, engage with peers, and never miss an opportunity.<br />Explore
                    events across seminars, sports, and cultural festivals.
                </p>
                <?php if (!isset($_SESSION['username'])): ?>
                    <div class="buttons" style="margin-top: 20px;">
                        <a href="../Homepage/signUp.html" class="register">Sign Up</a>
                        <a href="../Homepage/signInOpt.html" class="login">Log In</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <!-- Features Section -->
    <section class="features-section">
        <h2>Features</h2>
        <p>Discover the Key Features that Enhance Your Event Experience</p>
        <div class="card-container">
            <div class="card">
                <img src="../images/event.png" alt="Event Discovery" />
                <h3>Event Discovery</h3>
                <p>Browse Events: Explore events by category, date, or popularity.</p>
            </div>
            <div class="card">
                <img src="../images/create.png" alt="Event Creation" />
                <h3>Event Creation & Management</h3>
                <p>
                    Create Events: Set up new events with details like time and
                    location.
                </p>
            </div>
            <div class="card">
                <img src="../images/archive.png" alt="archive" />
                <h3>Past Events Archive</h3>
                <p>
                    Event Highlights: Access photos and videos from previous events.
                </p>
            </div>
            <div class="card">
                <img src="../images/feedback.jpg" alt="feedback" />
                <h3> Feedback & Ratings</h3>
                <p>Rate Events: Provide feedback to help improve future offerings</p>

            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="events-section">
        <h2>Discover Upcoming Events</h2>
        <p>Stay ahead of the curve with the latest events happening on campus!</p>
        <div class="card-container">
            <div class="event-container">
                <?php

                // Get events that are approved
                $sql = "SELECT * FROM approved_events";
                $result = $conn->query($sql);

                // Check if query was successful and if events are available
                if ($result && $result->num_rows > 0) {
                    $count = 0;
                    while ($count < 4 && ($row = $result->fetch_assoc())) {
                        $posterPath = '../uploads/' . $row['event_poster'];
                ?>

                        <div class="card">
                            <img src="<?= $posterPath ?>" alt="Event Poster" />
                            <h3><?= $row['event_name'] ?></h3>
                            <p>
                                Venue: <?= $row['event_venue'] ?><br>
                                Date: <?= $row['event_date'] ?><br>
                                Description: <?= $row['event_description'] ?>
                            </p>
                            <a href="eventDetails.php?event_id=<?= $row['id'] . '&from=upComingEventDetail' ?>" class="View-More">View More</a>
                        </div>

                <?php
                        $count++;
                    }
                } else {
                    echo "<div class='card'><p style='color:red;'>No events available or query error occurred.</p></div>";
                }
                ?>

            </div>
        </div>
    </section>
    <!-- End of Upcoming Events Section -->


    <!-- Event Archive Section -->
    <section class="events-section">
        <h2>Events Archive</h2>
        <p>
            Discover what made each experience special, view photos, and read
            reviews to get a taste of what’s in store for future events.
        </p>
        <div class="card-container">
            <div class="event-container">
                <?php
                // Fetch event requests from the database
                $sql = "SELECT * FROM archived_events";
                $result = $conn->query($sql);

                // Check if query was successful and if events are available
                if ($result && $result->num_rows > 0) {
                    $count = 0;
                    while ($count < 4 && ($row = $result->fetch_assoc())) {
                        $posterPath = '../uploads/' . $row['event_poster'];
                ?>

                        <div class="card">
                            <img src="<?= $posterPath ?>" alt="Event Poster" />
                            <h3><?= $row['event_name'] ?></h3>
                            <p>
                                Venue: <?= $row['event_venue'] ?><br>
                                Date: <?= $row['event_date'] ?><br>
                                Description: <?= $row['event_description'] ?>
                            </p>
                            <a href="eventDetails.php?event_id=<?= $row['id'] . '&from=archivedEventDetail' ?>" class="View-More">View More</a>
                        </div>

                <?php
                        $count++;
                    }
                } else {
                    echo "<div class='card'><p style='color:red;'>No events available or query error occurred.</p></div>";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>
    <!-- End of Event Archive Section -->
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