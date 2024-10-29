<?php
session_start();
$serverName = "localhost";
$username = "root";
$password = "";
$dbname = "unievent_master";

$conn = new mysqli($serverName, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch the event details
    $sql = "SELECT * FROM approved_events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();
} else {
    // Redirect if no ID is provided
    header("Location: upcomingEvents.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update event logic
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $eventVenue = $_POST['event_venue'];
    $eventDescription = $_POST['event_description'];
    $priceCategory = $_POST['price_category'];
    $eventPrice = $_POST['event_price'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Handle file upload
    $eventPoster = null;
    if (isset($_FILES['event_poster']) && $_FILES['event_poster']['error'] == UPLOAD_ERR_OK) {
        // Validate and move the uploaded file
        $uploadDir = '../uploads/';
        $eventPoster = basename($_FILES['event_poster']['name']);
        $uploadFile = $uploadDir . $eventPoster;

        if (move_uploaded_file($_FILES['event_poster']['tmp_name'], $uploadFile)) {
            // File uploaded successfully
        } else {
            $_SESSION['message'] = "Error uploading file.";
            $_SESSION['msg_type'] = "error";
            header("Location: edit_event.php?id=" . $eventId);
            exit();
        }
    } else {
        // If no new file is uploaded, keep the old one
        $eventPoster = $event['event_poster'];
    }

    $updateSql = "UPDATE approved_events SET event_name=?, event_date=?, event_venue=?, event_description=?, price_category=?, event_price=?, start_time=?, end_time=?, event_poster=? WHERE id=?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssssssssi", $eventName, $eventDate, $eventVenue, $eventDescription, $priceCategory, $eventPrice, $startTime, $endTime, $eventPoster, $eventId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Event updated successfully!";
        $_SESSION['msg_type'] = "success";
        header("Location: upcomingEvents.php");
    } else {
        $_SESSION['message'] = "Error updating event.";
        $_SESSION['msg_type'] = "error";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css ">
    <link rel="stylesheet" href="../css/edit.css">
    <title>Events | Event Archive</title>
</head>

<body>
    <nav class="navigationBar">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p class='" . $_SESSION['msg_type'] . "'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>
        <div></div>
        <div class="user">
            <span>
                <?php
                if (isset($_SESSION['admin_name'])) {
                    echo $_SESSION['admin_name'];
                } else {
                    echo 'Admin';
                }
                ?>
            </span>
            <img src="../images/mdi--user.svg" alt="profilePic" class="profilePic" />
        </div>
    </nav>
    <main>
        <div class="sidebar">
            <div class="logo">
                <a href="../Homepage/index.php"><img src="../images/microphone.png" alt="logo" height="25" width="35" /></a>
                <a href="../Homepage/index.php" class="logoText">UniEvent Master</a>
            </div>
            <ul class="sidebarLinks">
                <li><a href="./admin.php" class="mainLink "><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="mainLink active"><i class="fas fa-calendar-alt"></i>Events Management</a>
                    <ul class="submenu">
                        <li><a href="../Dashboard/eventRequest.php">Event Requests</a></li>
                        <li><a href="../Dashboard/upcomingEvents.php">Upcoming Events</a></li>
                        <li><a href="../Dashboard/eventArchive.php" class="active">Event Archive</a></li>

                    </ul>
                </li>
                <li><a href="../Dashboard/Messages.php" class="mainLink"><i class="fas fa-comments"></i>Messages</a></li>
                <li><a href="user_management.php" class="mainLink"><i class="fas fa-users"></i>User Management</a></li>

            </ul>
        </div>

        <section class="mainContent">
            <h1 style="margin-bottom: 15px;">Edit Event</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="event_name">Event Name:</label>
                <input type="text" name="event_name" value="<?php echo $event['event_name']; ?>" required><br>

                <label for="event_date">Event Date:</label>
                <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" required><br>

                <label for="event_venue">Event Venue:</label>
                <input type="text" name="event_venue" value="<?php echo $event['event_venue']; ?>" required><br>

                <label for="event_description">Description:</label>
                <textarea name="event_description" required><?php echo $event['event_description']; ?></textarea><br>

                <label for="price_category">Price Category:</label>
                <input type="text" name="price_category" value="<?php echo $event['price_category']; ?>" required><br>

                <label for="event_price">Event Price:</label>
                <input type="number" name="event_price" value="<?php echo $event['event_price']; ?>" required><br>

                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" value="<?php echo $event['start_time']; ?>" required><br>

                <label for="end_time">End Time:</label>
                <input type="time" name="end_time" value="<?php echo $event['end_time']; ?>" required><br>

                <label for="event_poster">Event Poster:</label>
                <?php if (isset($event['event_poster'])): ?>
                    <img src="../uploads/<?php echo $event['event_poster']; ?>" alt="Event Poster" width="100" height="100">
                <?php endif; ?>
                <input type="file" name="event_poster"><br>

                <input type="submit" value="Update Event">
            </form>
        </section>
    </main>
</body>

</html>