<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "unievent_master");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use real_escape_string to prevent SQL injection
    $name = $conn->real_escape_string($_POST['name']);
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM admin WHERE name='$name'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];

        // Verify the password using password_verify
        if ($password == $hashedPassword) {
            $_SESSION['logged_in'] = true;
            $_SESSION['name'] = $user['name'];
            $_SESSION['success_message'] = "You have successfully logged in!";
            header("Location: ../Dashboard/admin.php");
            exit();
        } else {
            echo "Invalid name or password";
        }
    } else {
        echo "Invalid name or password";
    }

    $conn->close();
} else {
    echo "Invalid request";
}
