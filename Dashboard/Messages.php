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

// Handle response submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['response'])) {
    $message_id = intval($_POST['message_id']);
    $admin_response = $conn->real_escape_string($_POST['response']);

    // Get user_id from session
    $user_id = $_SESSION['user_id'];

    // Insert the response into the responses table
    $sql = "INSERT INTO responses (message_id, admin_response, user_id) VALUES ('$message_id', '$admin_response', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Response sent successfully!";
        $_SESSION['msg_type'] = "successApprove";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "error";
    }
}

// Fetch data from the contact_us table
$sql = "SELECT * FROM contact_us";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Events | Event Requests</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 7px;
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        th {
            background-color: #023860;
            position: sticky;
            top: 0;
            z-index: 1;
            color: white;
            border-top: none;
        }
    </style>
</head>

<body>
    <!-- Confirmation Modal -->
    <?php include_once('../php/confirmation.php'); ?>
    <!-- Navigation Bar -->
    <nav class="navigationBar">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p class='success'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>
        <div></div>
        <div class="user">
            <span>
                <?php
                if (isset($_SESSION['admin_name'])) {
                    echo $_SESSION['admin_name'];
                } else {
                    echo 'Admin';
                }
                ?>
            </span>
            <img src="../images/mdi--user.svg" alt="profilePic" class="profilePic" />
        </div>
    </nav>
    <!-- End of Navigation Bar -->
    <main>
        <!-- Side Bar -->
        <div class="sidebar">
            <div class="logo">
                <a href="../Homepage/index.php"><img src="../images/microphone.png" alt="logo" height="25" width="35" /></a>
                <a href="../Homepage/index.php" class="logoText">UniEvent Master</a>
            </div>
            <ul class="sidebarLinks">
                <li><a href="./admin.php" class="mainLink"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="mainLink"><i class="fas fa-calendar-alt"></i>Events Management</a>
                    <ul class="submenu">
                        <li><a href="../Dashboard/eventRequest.php">Event Requests</a></li>
                        <li><a href="../Dashboard/upcomingEvents.php">Upcoming Events</a></li>
                        <li><a href="../Dashboard/eventArchive.php">Event Archive</a></li>
                    </ul>
                </li>
                <li><a href="../Dashboard/Messages.php" class="mainLink active"><i class="fas fa-comments"></i>Messages</a></li>
                <li><a href="user_management.php" class="mainLink"><i class="fas fa-users"></i>User Management</a></li>

            </ul>
        </div>

        <!-- End of Side Bar -->
        <!-- Main Content -->
        <section class="mainContent">
            <h1 style="margin-bottom: 15px;">Messages</h1>
            <p style="margin-bottom: 15px;">Here you can view all Messages sent by the users.</p>
            <div class="tableDiv">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($message = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['id']); ?></td>
                                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                                    <td><?php echo htmlspecialchars($message['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                                    <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                                    <td>
                                        <button onclick="document.getElementById('response-form-<?php echo $message['id']; ?>').style.display='block'">Respond</button>
                                    </td>
                                </tr>
                                <tr id="response-form-<?php echo $message['id']; ?>" style="display:none;">
                                    <td colspan="7">
                                        <form method="post">
                                            <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                            <textarea name="response" rows="4" cols="50" placeholder="Type your response here..."></textarea>
                                            <br>
                                            <input type="submit" value="Send Response">
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No messages found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

<?php
// Close the database connection
$conn->close();
?>

</html>