<?php
session_start();

function signup()
{
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
        if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['phone'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phone'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $checkEmailSql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($checkEmailSql);

            if ($result->num_rows > 0) {
                $_SESSION['error_message'] = "This email is already registered. Please use a different email.";
                header("Location: ../index.php");
                exit();
            } else {
                $insert = "INSERT INTO users (username, email, password, created_at, updated_at, phone_number) 
                    VALUES ('$username', '$email', '$password', NOW(), NOW(), '$phoneNumber')";

                if ($conn->query($insert) === TRUE) {
                    $_SESSION['successSignup'] = "Registration successful!";
                    $_SESSION['msg_type'] = "success";
                    header("Location: ../Homepage/index.php");
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
}

function login()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new mysqli("localhost", "root", "", "unievent_master");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password'];
            $username = $user['username'];
            $userId = $user['id'];

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $userId;
                $_SESSION['msg_type'] = "success";
                $_SESSION['successLogin'] = "You have successfully logged in!";
                header("Location: ../Homepage/index.php");
                exit();
            } else {
                echo "Invalid email or password";
            }
        } else {
            echo "Invalid email or password";
        }

        $conn->close();
    } else {
        echo "Invalid request";
    }
}

if (isset($_POST['submitSignUp'])) {
    signup();
} elseif (isset($_POST['submitLogin'])) {
    login();
} else {
    echo "Invalid request";
}
