<?php
$conn = new mysqli("localhost", "root", "", "unievent_master");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_get_feedback = "SELECT * FROM event_feedback";



$result_get_feedback = $conn->query($sql_get_feedback);

$user_id = $result_get_feedback->fetch_assoc()['user_id'];


$sql_get_users = "SELECT * FROM users WHERE id = '$user_id'";
$result_get_users = $conn->query($sql_get_users);

if ($result_get_feedback->num_rows > 0) {
    while ($row_get_feedback = $result_get_feedback->fetch_assoc()) {
        echo "<div class='chat-bubble'>
        <span>" . $result_get_users->fetch_assoc()['username'] . "</span> 
      <p>" . $row_get_feedback['feedback'] . "</p>
    </div>";
    }
} else {
    echo "No feedback yet.";
}

// Fetch feedback for the specific event
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
