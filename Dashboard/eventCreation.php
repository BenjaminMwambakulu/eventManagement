<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "unievent_master");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/edit.css">
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
            <h1 style="margin-bottom: 15px;">Create an Event</h1>
            <form
                id="eventForm"
                action="../php/submit.php"
                method="post"
                enctype="multipart/form-data">
                <!-- Event Information -->
                <div class="form-group">
                    <label for="eventName">Event Name</label>
                    <input type="text" id="eventName" name="eventName" required />
                </div>

                <div class="form-group">
                    <label for="eventDate">Event Date</label>
                    <input
                        type="date"
                        id="eventDate"
                        name="eventDate"
                        min="<?php echo date('Y-m-d'); ?>"
                        required>

                </div>

                <div class="form-group">
                    <label for="eventVenue">Event Venue</label>
                    <input type="text" id="eventVenue" name="eventVenue" required />
                </div>

                <div class="form-group">
                    <label for="eventDescription">Event Description</label>
                    <textarea
                        id="eventDescription"
                        name="eventDescription"
                        rows="4"
                        required></textarea>
                </div>
                <div class="form-group">
                    <label for="price-category">Price</label>
                    <select id="price-category" name="price-category" required>
                        <option value="" disabled selected>Select Price Category</option>
                        <option value="Free">Free</option>
                        <option value="Custom">Custom</option>
                    </select>
                </div>
                <div class="form-group" id="hide">
                    <label for="eventPrice">Enter Ticket Price</label>
                    <input type="number" id="eventPrice" name="eventPrice" />
                </div>

                <div class="form-group">
                    <label for="duration">Event Duration</label>
                    from
                    <input type="time" id="startTime" name="startTime" required /> to
                    <input type="time" id="endTime" name="endTime" required />
                </div>

                <div class="form-group">
                    <label for="eventPoster">Event Poster</label>
                    <input type="file" id="eventPoster" name="eventPoster" required />
                </div>
                <!-- Submit Button -->
                <button type="submit" name="submitUpcomingEvent" style="padding: 10px; background-color: #023860; color: white; border: none; border-radius: 5px; margin-top: 20px;">Submit Request</button>
            </form>
        </section>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let price = document.getElementById("price-category");
            let hiddenDiv = document.getElementById("hide");

            function toggleHiddenDiv() {
                if (price.value === "Free") {
                    hiddenDiv.style.display = "none";
                } else if (price.value === "Custom") {
                    hiddenDiv.style.display = "block";
                }
            }
            toggleHiddenDiv();
            price.addEventListener("change", toggleHiddenDiv);
        });
    </script>
</body>

</html>