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

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        $_SESSION['message'] = "User  deleted successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting user.";
        $_SESSION['msg_type'] = "error";
    }
    $stmt->close();
    header("Location: user_management.php");
    exit();
}

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_number = $_POST['phone_number'];
    $profile_pic = $_FILES['profile_pic']['name'];

    // Move uploaded file to the desired directory
    if (!empty($profile_pic)) {
        $uploadDir = '../uploads/';
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadDir . $profile_pic);
    } else {
        $profile_pic = null;
    }

    $insertSql = "INSERT INTO users (username, email, password, phone_number, profile_pic) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("sssss", $username, $email, $password, $phone_number, $profile_pic);
    if ($stmt->execute()) {
        $_SESSION['message'] = "User  added successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error adding user.";
        $_SESSION['msg_type'] = "error";
    }
    $stmt->close();
    header("Location: user_management.php");
    exit();
}

// Fetch users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/edit.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #023860;
            color: white;
        }

        .action-buttons a {
            margin-right: 10px;
            color: red;
        }


        .add-user-form {
            display: none;
            position: fixed;
            top: 100px;
            left: 320px;
            width: 500px;
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            border-radius: 5px;
        }

        form {
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
    <script>
        function toggleUserForm() {
            var form = document.getElementById('addUser Form');
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>
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
        <div class="user ">
            <span>Name Of The User</span>
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
                    <a href="#" class="mainLink"><i class="fas fa-calendar-alt"></i>Events Management</a>
                    <ul class="submenu">
                        <li><a href="../Dashboard/eventRequest.php">Event Requests</a></li>
                        <li><a href="../Dashboard/upcomingEvents.php">Upcoming Events</a></li>
                        <li><a href="../Dashboard/eventArchive.php">Event Archive</a></li>
                    </ul>
                </li>
                <li><a href="../Dashboard/Messages.php" class="mainLink"><i class="fas fa-comments"></i>Messages</a></li>
                <li><a href="user_management.php" class="mainLink active"><i class="fas fa-users"></i>User Management</a></li>
            </ul>
        </div>

        <section class="mainContent">
            <h1 style="margin-bottom: 15px;">User Management</h1>
            <button class="addUser" style="margin-bottom: 10px;" onclick="toggleUserForm()">Add New User</button>
            <div id="addUser Form" class="add-user-form">
                <h2 style="margin-bottom: 15px;">Add New User</h2>
                <form method="POST" action="" enctype="multipart/form-data">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required><br>

                    <label for="email">Email:</label>
                    <input type="email" name="email" required><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required><br>

                    <label for="phone_number">Phone Number:</label>
                    <input type="tel" name="phone_number" required><br>

                    <label for="profile_pic">Profile Picture:</label>
                    <input type="file" name="profile_pic"><br>

                    <input type="submit" value="Add User">
                </form>
            </div>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Profile Picture</th>
                    <th>Actions</th>
                </tr>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['phone_number']; ?></td>
                        <td>
                            <?php if (!empty($user['profile_pic'])): ?>
                                <img src="../uploads/<?php echo $user['profile_pic']; ?>" alt="Profile Picture" width="50" height="50">
                            <?php endif; ?>
                        </td>
                        <td class="action-buttons">
                            <a href="user_management.php?delete_id=<?php echo $user['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </section>
    </main>
</body>

</html>