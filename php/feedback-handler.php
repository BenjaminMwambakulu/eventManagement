<?php
// feedback-handler.php

session_start();


// Database connection

$conn = new mysqli("localhost", "root", "", "unievent_master");

// Assuming user is logged in
$userID = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = isset($_POST['event_id']) ? $_POST['event_id'] : null;

    if ($eventID === null) {
        echo "Event ID is missing.";
        exit;
    }

    $rating = $_POST['rating'];
    $feedback = $conn->real_escape_string($_POST['feedback']);

    // Insert feedback into the database
    $sql = "INSERT INTO event_feedback (user_id, event_id, rating, feedback) 
            VALUES ('$userID', '$eventID', '$rating', '$feedback')";
    if ($conn->query($sql) === TRUE) {
        $message = "Thank you for your feedback!";
        header("Location: ../Homepage/userBoard.php");
    } else {
        $message = "Error: " . $conn->error;
    }
}
