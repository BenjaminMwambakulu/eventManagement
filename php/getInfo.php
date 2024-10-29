<?php
function getUpcomingEventsDetails($event_id)
{
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

    // Fetch the specific event from the database
    $sql = "SELECT * FROM approved_events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $posterPath = '../uploads/' . $row['event_poster'];
    } else {
        echo "Event not found.";
        exit;
    }
    $conn->close();
    return $posterPath;
}

function getArchivedEventsDetails($event_id)
{
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

    // Fetch the specific event from the database
    $sql = "SELECT * FROM approved_events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $posterPath = '../uploads/' . $row['event_poster'];
    } else {
        echo "Event not found.";
        exit;
    }
    $conn->close();
    return $posterPath;
}

if (isset($_GET['event_id']) && $_GET['from'] == 'upComingEventDetail') {
    getUpcomingEventsDetails($_GET['event_id']);
}
if (isset($_GET['event_id']) && $_GET['from'] == 'archivedEventDetail') {
    getArchivedEventsDetails($_GET['event_id']);
}
