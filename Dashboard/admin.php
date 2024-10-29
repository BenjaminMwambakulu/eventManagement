<?php
session_start();
$conn = new mysqli("localhost", "root", "", "unievent_master");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['admin_id'])) {
    header("Location:../Dashboard/login.php");
    die("Please login");
}

// If session is set, proceed with the queries
$sql_get_requests = "SELECT * FROM `event_requests` ";
$sql_get_approved_events = "SELECT * FROM `approved_events`";
$sql_get_users = "SELECT * FROM `users`";
$sql_get_archived_events = "SELECT * FROM `archived_events`";
$todayDate = date("Y-m-d");
$sql_get_today_events = "SELECT * FROM `approved_events` WHERE `event_date` = '$todayDate'";

$result_get_requests = $conn->query($sql_get_requests);
$result_get_approved_events = $conn->query($sql_get_approved_events);
$result_get_users = $conn->query($sql_get_users);
$result_get_archived_events = $conn->query($sql_get_archived_events);
$result_get_today_events = $conn->query($sql_get_today_events);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Events </title>
</head>

<body>
    <!-- Confirmation Modal -->
    <?php include_once('../php/confirmation.php'); ?>
    <!-- Navigation Bar -->
    <nav class="navigationBar">
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
                <li><a href="#" class=" mainLink active"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="mainLink"><i class="fas fa-calendar-alt"></i>Events Management</a>
                    <ul class="submenu">
                        <li><a href="./eventRequest.php">Event Requests</a></li>
                        <li><a href="./upcomingEvents.php">Upcoming Events</a></li>
                        <li><a href="./eventArchive.php">Event Archive</a></li>
                    </ul>
                </li>
                <li><a href="../Dashboard/Messages.php" class="mainLink"><i class="fas fa-comments"></i>Messages</a></li>
                <li><a href="user_management.php" class="mainLink"><i class="fas fa-users"></i>User Management</a></li>

            </ul>
        </div>

        <!-- End of Side Bar -->
        <!-- Main Content -->
        <section class="mainContent">
            <h1 style="margin-bottom: 15px;">Welcome to the Admin Dashboard</h1>
            <div class="summaryCards">
                <div class="card">
                    <h3>Event Requests</h3>
                    <p>
                        <?php
                        if ($result_get_requests->num_rows > 0) {
                            echo $result_get_requests->num_rows;
                        } else {
                            echo "0";
                        }
                        ?>
                    </p>
                    <i class="fa-solid fa-calendar-check card-icon"></i>
                </div>
                <div class="card">
                    <h3>Upcoming Events</h3>
                    <p>
                        <?php
                        if ($result_get_approved_events->num_rows > 0) {
                            echo $result_get_approved_events->num_rows;
                        } else {
                            echo "0";
                        }
                        ?>
                    </p>
                    <i class="fa-solid fa-calendar-week card-icon"></i>
                </div>
                <div class="card">
                    <h3>Events In Archive</h3>
                    <p>
                        <?php
                        if ($result_get_archived_events->num_rows > 0) {
                            echo $result_get_archived_events->num_rows;
                        } else {
                            echo "0";
                        }
                        ?>
                    </p>
                    <i class="fa-regular fa-calendar-xmark"></i>
                </div>
                <div class="card">
                    <h3>Today Events</h3>
                    <p>
                        <?php
                        if ($result_get_today_events->num_rows > 0) {
                            echo $result_get_today_events->num_rows;
                        } else {
                            echo "0";
                        }
                        ?>
                    </p>
                    <i class="fa-solid fa-calendar-day card-icon"></i>
                </div>
            </div>
            <div class="summaryCards">
                <div class="card">
                    <h3>Total Number of Users</h3>
                    <p>
                        <?php
                        if ($result_get_users->num_rows > 0) {
                            echo $result_get_users->num_rows;
                        } else {
                            echo "0";
                        }
                        ?>
                    </p>
                    <i class="fa-solid fa-users card-icon"></i>
                </div>
            </div>
        </section>
    </main>
</body>

</html>