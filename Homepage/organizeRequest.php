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
  <link rel="stylesheet" href="../css/organizer.css" />
  <link rel="stylesheet" href="../css/home.css" />
  <title>organize Request</title>
</head>

<body>

  <body>
    <!-- Navigation -->
    <nav>
      <div class="logo">
        <img src="../images/microphone.png" alt="Logo" />
        <span>UniEvent Master</span>
      </div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="./eventDiscovery.php">Upcoming Events</a></li>
        <li><a href="./eventArchive.php">Event Archive</a></li>
        <li><a href="organizeRequest.php" class="navActive">Organize Request</a></li>
        <li><a href="./contactUs.php">Contact Us</a></li>
      </ul>
      <?php
      if (isset($_SESSION['username'])) {
        $sql_get_profile = "SELECT profile_pic FROM users WHERE id='" . $_SESSION['user_id'] . "'";
        $result = $conn->query($sql_get_profile);
        $row = $result->fetch_assoc();
        $profile_pic = $row['profile_pic'];
        echo "
            <div class='userProfile' style='display:flex;'>
                <a href='./userBoard.php'>
                    <span>" . $_SESSION['username'] . "</span>
                    <img src='$profile_pic' alt='Profile Picture' />
                </a>
            </div>";
      } ?>


      <div class="buttons" style="<?php echo isset($_SESSION['username']) ? 'display: none;' : ''; ?>">
        <a href="./signUp.html" class="register">Sign Up</a>
        <a href="../Homepage/signInOpt.html" class="login">Log In</a>
      </div>
      </div>
    </nav>
    <!-- End of Navigation -->

    <!-- Event Request Section -->
    <div class="container">
      <h2>Event Request Form</h2>
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
          <input type="file" id="eventPoster" name="eventPoster" />
        </div>
        <!-- Submit Button -->
        <button type="submit" name="submitEvent">Submit Request</button>
      </form>
    </div>
    <!-- Footer Section -->
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-section logo">
          <img src="../images/microphone.png" alt="Logo" />
          <span><a href="../Homepage/index.php">UniEvent Master</a></span>
        </div>
        <div class="footer-section links-section">
          <h4 class="footer-heading">Quick Links</h4>
          <ul class="footer-links">
            <li><a href="#" class="footer-link">Home</a></li>
            <li><a href="#" class="footer-link">Upcoming Events</a></li>
            <li><a href="#" class="footer-link">Previous Events</a></li>
            <li><a href="#" class="footer-link">Organize Request</a></li>
            <li><a href="#" class="footer-link">About Us</a></li>
          </ul>
        </div>
        <div class="footer-section contact-section">
          <h4 class="footer-heading">Contact Info</h4>
          <p class="footer-contact">Email: eventMaster@gmail.com</p>
          <p class="footer-contact">Phone Number: (265) 885705304</p>
        </div>
      </div>
    </footer>
    <!-- End of Footer Section -->
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
</body>

</html>