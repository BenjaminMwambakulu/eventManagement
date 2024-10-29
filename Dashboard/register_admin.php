<?php
// Database connection
$serverName = "localhost";
$username = "root";
$password = "";
$dbname = "unievent_master";

$conn = new mysqli($serverName, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_email = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        $error = "Email already exists!";
    } else {
        // Insert new admin
        $sql = "INSERT INTO admin (name, email, password) VALUES ('$name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to login page with success message
            header("Location: login.php?registration=success");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/userAuth.css">
</head>

<body>
    <div class="container">
        <h2>Admin Sign up</h2>
        <p>Create your account</p>
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password1">Password</label>
                <input type="password" id="password1" name="password1" required minlength="8">
            </div>
            <div>
                <label for="password">Confirm Password</label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>
            <button type="submit">Sign up</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <script>
        const password1 = document.getElementById("password1");
        const password = document.getElementById("password");

        password1.addEventListener("input", function() {
            if (password1.value != password.value) {
                password.setCustomValidity("Passwords do not match");
            } else {
                password.setCustomValidity("");
            }
        });

        password.addEventListener("input", function() {
            if (password1.value != password.value) {
                password.setCustomValidity("Passwords do not match");
            } else {
                password.setCustomValidity("");
            }
        });
    </script>
</body>

</html>