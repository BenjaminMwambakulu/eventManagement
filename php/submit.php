<?php
session_start();
function submitEventRequest()
{
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unievent_master";

    $conn = new mysqli($serverName, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $eventSubmit = $_POST["submitEvent"];

        $userID = $_SESSION['user_id'];

        $eventName = ($_POST['eventName']);
        $eventDate = ($_POST['eventDate']);
        $eventVenue = ($_POST['eventVenue']);
        $eventDescription = ($_POST['eventDescription']);
        $priceCategory = ($_POST['price-category']);
        $eventPrice = isset($_POST['eventPrice']) ? ($_POST['eventPrice']) : null;
        $startTime = ($_POST['startTime']);
        $endTime = ($_POST['endTime']);

        $eventPoster = $_FILES['eventPoster'];
        $uploadDir = '../uploads/';

        $fileExtension = pathinfo($eventPoster['name'], PATHINFO_EXTENSION);
        $uniqueFileName = uniqid() . '.' . $fileExtension;
        $uploadFile = $uploadDir . $uniqueFileName;

        if ($eventPoster['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($eventPoster['tmp_name'], $uploadFile)) {
                $sql = "INSERT INTO event_requests (event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster, user_id)
                    VALUES ('$eventName', '$eventDate', '$eventVenue', '$eventDescription', '$priceCategory', '$eventPrice', '$startTime', '$endTime', '$uniqueFileName', '$userID')";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] = "Request submitted successfully.";
                    $_SESSION['msg_type'] = "success";
                    header("location:../Homepage/index.php");
                    exit();
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Error uploading file.";
        }
    }

    $conn->close();
}
function uploadImage()
{
    // Database connection credentials
    $host = "localhost";
    $dbname = "unievent_master";
    $username = "root";
    $password = "";

    // Create a new MySQLi connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if form was submitted and if file is uploaded
    if (isset($_POST['submitImage']) && isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        // Make sure user is logged in
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            // Directory where the file will be saved
            $targetDir = "../profile_pictures/";

            // Create the uploads directory if it doesn't exist
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Get file information
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFilePath = $targetDir . $fileName;

            // Move the uploaded file
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
                // Prepare the SQL query to update the user's profile picture path
                $sql = "UPDATE `users` SET `profile_pic` = '$targetFilePath' WHERE `id` = $userId";

                // Execute the query without sanitization
                if ($conn->query($sql) === TRUE) {
                    header("location:../Homepage/profileSettings.php");
                    $_SESSION['profile_pic'] = $targetFilePath;
                    exit();
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "Sorry, there was an error moving your file.";
            }
        } else {
            echo "User ID not set in session.";
        }
    } else {
        echo "No file uploaded or an error occurred during the upload.";
    }

    // Close the database connection
    $conn->close();
}

function submitUpcomingEvent()
{

    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unievent_master";

    // Create connection
    $conn = new mysqli($serverName, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eventSubmit = $_POST["submitEvent"] ?? null;

        $userID = $_SESSION['user_id'] ?? null;

        // Sanitize input
        $eventName = $conn->real_escape_string(trim($_POST['eventName']));
        $eventDate = $conn->real_escape_string(trim($_POST['eventDate']));
        $eventVenue = $conn->real_escape_string(trim($_POST['eventVenue']));
        $eventDescription = $conn->real_escape_string(trim($_POST['eventDescription']));
        $priceCategory = $conn->real_escape_string(trim($_POST['price-category']));
        $eventPrice = isset($_POST['eventPrice']) ? $conn->real_escape_string(trim($_POST['eventPrice'])) : null;
        $startTime = $conn->real_escape_string(trim($_POST['startTime']));
        $endTime = $conn->real_escape_string(trim($_POST['endTime']));

        // Handle file upload
        $eventPoster = $_FILES['eventPoster'];
        $uploadDir = '../uploads/';

        if ($eventPoster['error'] === UPLOAD_ERR_OK) {
            $fileExtension = pathinfo($eventPoster['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $uniqueFileName;

            if (move_uploaded_file($eventPoster['tmp_name'], $uploadFile)) {
                $stmt = $conn->prepare("INSERT INTO approved_events (event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssss", $eventName, $eventDate, $eventVenue, $eventDescription, $priceCategory, $eventPrice, $startTime, $endTime, $uniqueFileName);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Submitted successfully.";
                    $_SESSION['msg_type'] = "success";
                    header("Location: ../Dashboard/UpcomingEvents.php");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Error uploading file.";
        }
    }
}


if (isset($_POST['submitEvent'])) {
    submitEventRequest();
}

if (isset($_POST['submitImage'])) {
    uploadImage();
}
if (isset($_POST['submitUpcomingEvent'])) {
    submitUpcomingEvent();
}
