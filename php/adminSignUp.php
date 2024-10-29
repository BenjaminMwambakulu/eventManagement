<?php
session_start();
$serverName = "localhost";
$username = "root";
$password = "";
$dbname = "unievent_master";

$conn = new mysqli($serverName, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'], $_POST['password'], $_POST['phone_number'])) {
        $name = $_POST['name'];
        $password = $_POST['password']; // Get the plain password
        $phoneNumber = $_POST['phone_number'];

        // Hash the password before storing it
        $hashedPassword = $password;

        // Check if the phone number is already registered
        $checkPhoneSql = "SELECT * FROM admin WHERE phone_number = '$phoneNumber'";
        $result = $conn->query($checkPhoneSql);

        if ($result->num_rows > 0) {
            $_SESSION['error_message'] = "This phone number is already registered. Please use a different phone number.";
            exit();
        } else {
            // Insert the new admin record into the database
            $insert = "INSERT INTO admin (name, password, phone_number) 
                    VALUES ('$name', '$hashedPassword', '$phoneNumber')";

            if ($conn->query($insert) === TRUE) {
                $_SESSION['message'] = "Registration successful!";
                $_SESSION['admin_name'] = $name;
                $_SESSION['msg_type'] = "successAdminRegister";
                header(header: "Location: ./adminSignUp.php");
                echo "Registration successful!";
                exit();
            } else {
                echo "Error: " . $insert . "<br>" . $conn->error;
            }
        }
    } else {
        echo "All fields are required.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
