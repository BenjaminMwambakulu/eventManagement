<?php
session_start();
// Function to approve event request
function approveEvent()
{

    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unievent_master";

    $conn = new mysqli($serverName, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $sql = "SELECT event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster FROM event_requests WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $insertSql = "INSERT INTO approved_events (event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster) VALUES ('" . $row['event_name'] . "', '" . $row['event_date'] . "', '" . $row['event_venue'] . "', '" . $row['event_description'] . "', '" . $row['price_category'] . "', '" . $row['event_price'] . "', '" . $row['start_time'] . "', '" . $row['end_time'] . "', '" . $row['event_poster'] . "')";

            if ($conn->query($insertSql) === TRUE) {
                $deleteSql = "DELETE FROM event_requests WHERE id = $id";
                $conn->query($deleteSql);
                $_SESSION['message'] = "Event approved successfully.";
                $_SESSION['msg_type'] = "successApprove";
            } else {
                $_SESSION['message'] = "Error approving event: " . $conn->error;
                $_SESSION['msg_type'] = "errorApprove";
            }
        } else {
            $_SESSION['message'] = "Event request not found.";
        }
    } else {
        $_SESSION['message'] = "No event ID specified.";
    }

    $conn->close();
    header("location: ../Dashboard/eventRequest.php");
    exit();
}

// Function to reject event request
function rejectEvent()
{
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
        $id = intval($_GET['id']);

        // Delete the event request
        $sql = "DELETE FROM event_requests WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Event rejected successfully.";
            $_SESSION['msg_type'] = "successReject";
        } else {
            $_SESSION['message'] = "Error rejecting event: " . $conn->error;
            $_SESSION['msg_type'] = "errorReject";
        }
    } else {
        $_SESSION['message'] = "No event ID specified.";
    }

    $conn->close();
    header("location: ../Dashboard/eventRequest.php");
    exit();
}

function archiveEvent()
{
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unievent_master";

    $conn = new mysqli($serverName, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $sql = "SELECT event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster FROM approved_events WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $insertSql = "INSERT INTO archived_events (event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster) 
                      VALUES ('" . $row['event_name'] . "', '" . $row['event_date'] . "', '" . $row['event_venue'] . "', '" . $row['event_description'] . "', '" . $row['price_category'] . "', '" . $row['event_price'] . "', '" . $row['start_time'] . "', '" . $row['end_time'] . "', '" . $row['event_poster'] . "')";

            if ($conn->query($insertSql) === TRUE) {
                $deleteSql = "DELETE FROM approved_events WHERE id = $id";
                $conn->query($deleteSql);
                $_SESSION['message'] = "Event Archived successfully.";
                $_SESSION['msg_type'] = "successArchive";
            } else {
                $_SESSION['message'] = "Error Archiving event: " . $conn->error;
                $_SESSION['msg_type'] = "errorArchive";
            }
        } else {
            $_SESSION['message'] = "Event not found.";
        }
    } else {
        $_SESSION['message'] = "No event ID specified.";
    }

    $conn->close();
    header("location: ../Dashboard/upcomingEvents.php");
    exit();
}

function deleteEvent()
{
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unievent_master";

    $conn = new mysqli($serverName, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $deleteSql = "DELETE FROM archived_events WHERE id = $id";
        $conn->query($deleteSql);
        $_SESSION['message'] = "Event Deleted successfully.";
        $_SESSION['msg_type'] = "successDelete";
    } else {
        $_SESSION['message'] = "No event ID specified.";
        $_SESSION['msg_type'] = "errorDelete";
    }

    $conn->close();
    header("location: ../Dashboard/eventArchive.php");
    exit();
}

if (isset($_GET['id']) && $_GET['name'] == "approveAction") {
    approveEvent();
} elseif (isset($_GET['id']) && $_GET['name'] == "rejectAction") {
    rejectEvent();
} elseif (isset($_GET['id']) && $_GET['name'] == "archiveAction") {
    archiveEvent();
} elseif (isset($_GET['id']) && $_GET['name'] == "deleteAction") {
    deleteEvent();
}
