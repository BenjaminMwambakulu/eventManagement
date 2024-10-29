<?php
session_start();

$userID = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "unievent_master");

if (isset($_SESSION['username'])) {
    $sql_get_event_ids = "SELECT event_id FROM event_registrations WHERE user_id = '" . $userID . "'";
    $result_get_event_ids = $conn->query($sql_get_event_ids);

    $event_ids = [];
    if ($result_get_event_ids->num_rows > 0) {
        while ($row = $result_get_event_ids->fetch_assoc()) {
            $event_ids[] = $row['event_id'];
        }
    }

    if (!empty($event_ids)) {
        $event_ids_list = implode(',', $event_ids);
        $sql_get_approved_events = "SELECT event_name, event_date, start_time, event_venue 
                                     FROM approved_events 
                                     WHERE id IN ($event_ids_list) AND event_date >= CURDATE()";
        $result_get_approved_events = $conn->query($sql_get_approved_events);
        $approved_events_count = $result_get_approved_events->num_rows;
    } else {
        $approved_events_count = 0;
        $result_get_approved_events = null;
    }

    $sql_get_past_events = "SELECT ae.event_name, ae.event_date, er.event_id 
                            FROM archived_events ae 
                            JOIN event_registrations er ON ae.id = er.event_id 
                            WHERE er.user_id = '$userID' 
                            ORDER BY ae.event_date DESC";
    $result_get_past_events = $conn->query($sql_get_past_events);

    $sql_get_notifications = "SELECT message_id, admin_response, created_at FROM responses WHERE user_id = '$userID' ORDER BY created_at DESC";
    $result_get_notifications = $conn->query($sql_get_notifications);
    $notifications_count = $result_get_notifications->num_rows;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/userdashboard.css">
    <link rel="stylesheet" href="../css/feedback.css">
    <title>User Board</title>
</head>

<body>
    <nav>
        <div class="logo">
            <img src="../images/microphone.png" alt="Logo" />
            <span><a href="../Homepage/index.php">UniEvent Master</a></span>
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
            $result = $conn->query($sql_get_profile);
            $row = $result->fetch_assoc();
            $profile_pic = $row['profile_pic'];
            echo "
            <div class='userProfile' style='display:flex;'>
                <a href=''>
                    <span>" . $_SESSION['username'] . "</span>
                    <img src='$profile_pic' alt='Profile Picture' />
                </a>
            </div>";
        } ?>
    </nav>

    <div class="dashboard-container" style="margin-top: 80px;">
        <header class="dashboard-header ">
            <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
            <p>Here’s an overview of your upcoming events and activities.</p>
        </header>

        <section class="dashboard-section overview">
            <h2>Overview</h2>
            <div class="summaryCards">
                <div class="card">
                    <h3>Registered Events</h3>
                    <p>
                        <?php echo $approved_events_count; ?>
                    </p>
                    <i class="fa-solid fa-calendar-check card-icon"></i>
                </div>
                <div class="card">
                    <h3>Events Attended</h3>
                    <p>
                        <?php echo $result_get_past_events->num_rows; ?>
                    </p>
                    <i class="fa-solid fa-calendar-times card-icon"></i>
                </div>
                <div class="card">
                    <h3>Notifications</h3>
                    <p>
                        <?php echo $notifications_count; ?>
                    </p>
                    <i class="fa-solid fa-bell card-icon"></i>
                </div>
                <div class="card">
                    <h3>Profile</h3>
                    <p>click the icon</p>
                    <a href="./profileSettings.php"><i class="fa-solid fa-user-circle card-icon"></i></a>
                </div>
            </div>
        </section>

        <section class="dashboard-section events">
            <h2>Upcoming Approved Events</h2>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_get_approved_events) {
                        while ($row = $result_get_approved_events->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['event_name'] . "</td>";
                            echo "<td>" . $row['event_date'] . "</td>";
                            echo "<td>" . $row['start_time'] . "</td>";
                            echo "<td>" . $row['event_venue'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No approved events found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section class="dashboard-section past-events">
            <h2>Past Attended Events</h2>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_get_past_events) {
                        while ($row = $result_get_past_events->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['event_name'] . "</td>";
                            echo "<td>" . $row['event_date'] . "</td>";
                            echo '<td><a href="javascript:void(0);" onclick="openModal(\'' . $row['event_id'] . '\')">Add Feedback</a><br><a href="#">View Media</a></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No past events found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="modal" id="feedbackModal">
                <div class="feedback-container">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h1>Rate & Provide Feedback</h1>
                    <p>We appreciate your feedback to help us improve our events!</p>
                    <?php if (isset($message)) {
                        echo "<p>$message</p>";
                    } ?>
                    <form action="../php/feedback-handler.php" method="POST">
                        <input type="hidden" name="event_id" id="eventIDInput">
                        <label for="rating">Rating (1-5):</label>
                        <select name="rating" id="rating" required>
                            <option value="" disabled selected>Select rating</option>
                            <option value="1">1 - Very Dissatisfied</option>
                            <option value="2">2 - Dissatisfied</option>
                            <option value="3">3 - Neutral</option>
                            <option value="4">4 - Satisfied</option>
                            <option value="5">5 - Very Satisfied</option>
                        </select>
                        <label for="feedback">Your Feedback:</label>
                        <textarea name="feedback" id="feedback" rows="5" required></textarea>
                        <button type="submit">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="dashboard-section events">
            <h2>Notifications</h2>
            <table>
                <thead>
                    <tr>
                        <th>Message ID</th>
                        <th>Admin Response</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_get_notifications) {
                        while ($notification = $result_get_notifications->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $notification['message_id'] . "</td>";
                            echo "<td>" . $notification['admin_response'] . "</td>";
                            echo "<td>" . $notification['created_at'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No notifications found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
    <script>
        function openModal(eventID) {
            document.getElementById("feedbackModal").style.display = "block";
            document.getElementById("eventIDInput").value = eventID;
        }

        function closeModal() {
            document.getElementById("feedbackModal").style.display = "none";
        }
    </script>
</body>

</html>