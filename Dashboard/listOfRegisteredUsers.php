<?php
session_start();
$conn = new mysqli("localhost", "root", "", "unievent_master");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch event_registrations for the specific event
    $sql_get_registrations = "
        SELECT u.username, r.registration_date 
        FROM event_registrations r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.event_id = '$eventId'
    ";
    $result_get_registrations = mysqli_query($conn, $sql_get_registrations);

    // Fetch organizer information if needed
    $sql_get_event = "SELECT * FROM approved_events WHERE id = '$eventId'";
    $result_get_event = mysqli_query($conn, $sql_get_event);
    $event = $result_get_event->fetch_assoc();
    $eventName = $event['event_name'];
} else {
    header("Location:../Dashboard/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Events | Users Registered for <?php echo $eventName; ?></title>
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
    <!-- Navigation Bar -->
    <nav class="navigationBar">
        <?php
        if (isset($_SESSION['message']) && $_SESSION['msg_type'] == "successArchive") {
            echo "<p class='success'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        if (isset($_SESSION['message']) && $_SESSION['msg_type'] == "success") {
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
        <!-- Confirmation Modal -->
        <?php include_once('../php/confirmation.php'); ?>

        <!-- Side Bar -->
        <div class="sidebar">
            <div class="logo">
                <a href="../Homepage/index.php"><img src="../images/microphone.png" alt="logo" height="25" width="35" /></a>
                <a href="../Homepage/index.php" class="logoText">UniEvent Master</a>
            </div>
            <ul class="sidebarLinks">
                <li><a href="./admin.php" class="mainLink"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="mainLink active"><i class="fas fa-calendar-alt"></i>Events Management</a>
                    <ul class="submenu">
                        <li><a href="../Dashboard/eventRequest.php">Event Requests</a></li>
                        <li><a href="../Dashboard/upcomingEvents.php" class="active">Upcoming Events</a>
                        </li>
                        <li><a href="../Dashboard/eventArchive.php">Event Archive</a></li>
                    </ul>
                </li>
                <li><a href="../Dashboard/Messages.php" class="mainLink"><i class="fas fa-comments"></i>Messages</a></li>
                <li><a href="user_management.php" class="mainLink"><i class="fas fa-users"></i>User Management</a></li>

            </ul>
        </div>

        <!-- End of Side Bar -->
        <!-- Main Content -->
        <section class="mainContent">
            <h1 style="margin-bottom: 15px;">List Users Registered for <?php echo $eventName; ?></h1>
            <div class="tableDiv">
                <table>
                    <thead>
                        <th>Registered User</th>
                        <th>Registration Date</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($registration = $result_get_registrations->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $registration['username'] . "</td>";
                            echo "<td>" . $registration['registration_date'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </section>
        <!-- End of Main Content -->
    </main>
</body>

</html>