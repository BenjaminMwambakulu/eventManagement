<?php
// Start session to display success or error messages
session_start();

// Database connection
$serverName = "localhost";
$username = "root";
$password = "";
$dbname = "unievent_master";

$conn = new mysqli($serverName, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch event requests
$sql = "SELECT id, user_id, event_name, event_date, event_venue, event_description, price_category, event_price, start_time, end_time, event_poster FROM event_requests";
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
        if (isset($_SESSION['message']) && $_SESSION['msg_type'] == "successReject") {
            echo "<p class='success'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        } elseif (isset($_SESSION['message']) && $_SESSION['msg_type'] == "successApprove") {
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
                <li><a href="./admin.php" class=" mainLink "><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="mainLink active"><i class="fas fa-calendar-alt"></i>Events Management</a>
                    <ul class="submenu">
                        <li><a href="../Dashboard/eventRequest.php" class="active">Event Requests</a></li>
                        <li><a href="../Dashboard/upcomingEvents.php">Upcoming Events</a></li>
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
            <h1 style="margin-bottom: 15px;">Event Requests</h1>
            <p style="margin-bottom: 15px;">Here you can view all the event requests made by the users.</p>
            <div class="tableDiv">
                <table>
                    <thead>
                        <th>Organizer</th>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Event Venue</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Time</th>
                        <th>Poster</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $Approve = "&name=approveAction";
                        $Reject = "&name=rejectAction";
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['user_id'] . "</td>";
                                echo "<td>" . $row['event_name'] . "</td>";
                                echo "<td>" . $row['event_date'] . "</td>";
                                echo "<td>" . $row['event_venue'] . "</td>";
                                echo "<td>" . $row['event_description'] . "</td>";
                                echo "<td>" . ($row['event_price'] !== null ? $row['event_price'] : "Free") . "</td>";
                                echo "<td>" . $row['start_time'] . "&#8594;" . $row['end_time'] . "</td>";
                                echo "<td><img src='../uploads/" . $row['event_poster'] . "' alt='Poster' style='width: 100px; height: 80px;'/></td>";
                                echo "<td>
                                <div class='action-buttons'>
                                    <a href='#' class='approve' onclick=\"openModal('Are you sure you want to Approve this event?', '../php/eventCycleManagement.php?id=" . $row['id'] . $Approve . "')\">Approve</a>
                                    <a href='#' class='reject' onclick=\"openModal('Are you sure you want to reject this event?', '../php/eventCycleManagement.php?id=" . $row['id'] . $Reject . "')\">Reject</a>
                                </div>
                            </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No event requests found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>