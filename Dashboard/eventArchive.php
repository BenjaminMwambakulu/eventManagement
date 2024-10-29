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

// Handle media upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_media'])) {
    $eventId = $_POST['event_id'];
    $mediaType = $_POST['media_type'];

    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] == 0) {
        $fileTmpPath = $_FILES['media_file']['tmp_name'];
        $fileName = $_FILES['media_file']['name'];
        $uploadFileDir = '../uploads/';
        $dest_path = $uploadFileDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $insertSql = "INSERT INTO event_media (event_id, media_type, media_path) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("iss", $eventId, $mediaType, $fileName);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Media uploaded successfully.";
                $_SESSION['msg_type'] = "successUpload";
            } else {
                $_SESSION['message'] = "Error uploading media: " . $stmt->error;
                $_SESSION['msg_type'] = "errorUpload";
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = "Error moving the uploaded file.";
            $_SESSION['msg_type'] = "errorUpload";
        }
    } else {
        $_SESSION['message'] = "No file uploaded or there was an upload error.";
        $_SESSION['msg_type'] = "errorUpload";
    }
}

// Handle event deletion
if (isset($_GET['delete_event_id'])) {
    $eventIdToDelete = $_GET['delete_event_id'];

    // Delete associated media files
    $mediaSql = "SELECT media_path FROM event_media WHERE event_id = ?";
    $mediaStmt = $conn->prepare($mediaSql);
    $mediaStmt->bind_param("i", $eventIdToDelete);
    $mediaStmt->execute();
    $mediaResult = $mediaStmt->get_result();

    while ($mediaRow = $mediaResult->fetch_assoc()) {
        $mediaPath = '../uploads/' . $mediaRow['media_path'];
        if (file_exists($mediaPath)) {
            unlink($mediaPath); // Delete the file from the server
        }
    }
    $mediaStmt->close();

    // Now delete the event
    $deleteSql = "DELETE FROM archived_events WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $eventIdToDelete);
    if ($deleteStmt->execute()) {
        $_SESSION['message'] = "Event deleted successfully.";
        $_SESSION['msg_type'] = "successDelete";
    } else {
        $_SESSION['message'] = "Error deleting event: " . $deleteStmt->error;
        $_SESSION['msg_type'] = "errorDelete";
    }
    $deleteStmt->close();
}

// Fetch archived events
$sql = "SELECT id, event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster FROM archived_events";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Events | Event Archive</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 7px;
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        th {
            background-color: #023860;
            position: sticky;
            top: 0;
            z-index: 1;
            color: white;
            border-top: none;
        }
    </style>
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
            <h1 style="margin-bottom: 15px;">Event Archive</h1>
            <p style="margin-bottom: 15px;">View all past events</p>
            <div class="tableDiv">
                <table>
                    <thead>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Event Venue</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Time</th>
                        <th>Poster</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['event_name'] . "</td>";
                                echo "<td>" . $row['event_date'] . "</td>";
                                echo "<td>" . $row['event_venue'] . "</td>";
                                echo "<td>" . $row['event_description'] . "</td>";
                                echo "<td>" . ($row['event_price'] !== null ? $row['event_price'] : "Free") . "</td>";
                                echo "<td>" . $row['start_time'] . "&#8594;" . $row['end_time'] . "</td>";
                                echo "<td><img src='../uploads/" . $row['event_poster'] . "' alt='Poster' style='width: 100px; height: 80px;'/></td>";
                                echo "<td>
                                    <div class='action-buttons'>
                                        <form action='' method='post' enctype='multipart/form-data'>
                                            <input type='hidden' name='event_id' value='" . $row['id'] . "'>
                                            <input type='file' name='media_file'><br><br>
                                            <select name='media_type'>
                                                <option value='image'>Image</option>
                                                <option value='video'>Video</option>
                                                <option value='other'>Other</option>
                                            </select>
                                            <button type='submit' name='upload_media'>Upload Media</button>
                                        </form>
                                        <a style='color:Red;' href='?delete_event_id=" . $row['id'] . "' class='delete-button'>Delete Event</a>
                                    </div>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No event requests found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>