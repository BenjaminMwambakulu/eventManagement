<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "unievent_master");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  // Insert data into the database
  $sql = "INSERT INTO contact_us (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

  if ($conn->query($sql) === TRUE) {
    $msg = "Message sent successfully!";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/home.css" />
  <link rel="stylesheet" href="../css/contactUs.css" />
  <title>Contact Us</title>
</head>

<body>
  <!-- Navbar Section -->
  <nav>
    <div class="logo">
      <img src="../images/microphone.png" alt="Logo" />
      <span>UniEvent Master</span>
    </div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="./eventDiscovery.php">Upcoming Events</a></li>
      <li><a href="./eventArchive.php">Event Archive</a></li>
      <li><a href="organizeRequest.php">Organize Request</a></li>
      <li><a href="./contactUs.php" class="navActive">Contact Us</a></li>
    </ul>
    <?php
    if (isset($_SESSION['username'])) {
      $sql_get_profile = "SELECT profile_pic FROM users WHERE id='" . $_SESSION['user_id'] . "'";
      $resultProfile = $conn->query($sql_get_profile);
      $rowProfile = $resultProfile->fetch_assoc();
      $profile_pic = $rowProfile['profile_pic'];
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
      <a href="./login.html" class="login">Log In</a>
    </div>
  </nav>
  <!-- End of Navigation -->

  <div class="container">
    <div class="contactUs">
      <?php echo isset($msg) ? "<p class='success'>$msg</p>" : ""; ?>
      <h1 class="event-heading">Contact Us</h1>
      <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required />
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
        <button type="submit" class="submitBtn">Submit</button>
      </form>
    </div>
    <div class="banner-container">
      <img src="../images/contactLogo.webp" alt="" />
    </div>
  </div>
  <div class="card-container" style="margin-bottom: 15px">
    <div class="card">
      <h3>Address</h3>
      <p>P.O. Box 5196, Limbe, Malawi <br /></p>
      <button
        disabled
        style="background-color: gray"
        id="moreBtnAddress"
        onclick="showMap()">
        More
      </button>
      <div id="map" style="display: none">
        <iframe
          width="249"
          height="200"
          src="https://www.google.com/maps/place/Malawi+University+of+Science+and+Technology/@-15.9019872,35.2142716,17z/data=!3m1!4b1!4m6!3m5!1s0x18d9cad291cec51f:0xc98b4ac16beed81b!8m2!3d-15.9019872!4d35.2168465!16s%2Fg%2F11cmhyc6jh?entry=ttu&g_ep=EgoyMDI0MTAwOS4wIKXMDSoASAFQAw%3D%3D"
          frameborder="0"
          style="border: 0"
          allowfullscreen=""
          aria-hidden="false"
          tabindex="0"></iframe>
      </div>
    </div>

    <script>
      function showMap() {
        var mapDiv = document.getElementById("map");
        var moreBtn = document.getElementById("moreBtnAddress");
        if (mapDiv.style.display === "none") {
          mapDiv.style.display = "block";
          moreBtn.innerText = "Less";
        } else {
          mapDiv.style.display = "none";
          moreBtn.innerText = "More";
        }
      }
    </script>

    <div class="card">
      <h3>Phone</h3>
      <p id="phone">+265 111 678 000</p>
      <button id="moreBtnPhone" onclick="showMorePhones()">More</button>
      <p id="additionalPhone" style="display: none">
        +265 888 705 304 <br />
        +265 982 716 345 <br />
        +265 881 119 452 <br />
        +265 886 939 998 <br />
        +265 992 056 958 <br />
        +265 986 791 391 <br />
        +265 991 490 739
      </p>
      <script>
        function showMorePhones() {
          var additionalPhones = document.getElementById("additionalPhone");
          var moreBtn = document.getElementById("moreBtnPhone");
          if (additionalPhones.style.display === "none") {
            additionalPhones.style.display = "block";
            moreBtn.innerText = "Less";
          } else {
            additionalPhones.style.display = "none";
            moreBtn.innerText = "More";
          }
        }
      </script>
    </div>

    <div class="card">
      <h3>Email</h3>
      <p id="email1">registrar@must.ac.mw</p>
      <button id="moreBtnEmail" onclick="showMoreEmails()">More</button>
      <p id="additionalEmails" style="display: none">
        bit-023-22@must.ac.mw<br />
        bit-008-22@must.ac.mw<br />
        bit-024-22@must.ac.mw <br />
        css-028-22@must.ac.mw <br />
        css-004-22@must.ac.mw<br />
        bme-015-21@must.ac.mw <br />
        bit-104-21@must.ac.mw
      </p>
      <script>
        function showMoreEmails() {
          var additionalEmails = document.getElementById("additionalEmails");
          var moreBtn = document.getElementById("moreBtnEmail");
          if (additionalEmails.style.display === "none") {
            additionalEmails.style.display = "block";
            moreBtn.innerText = "Less";
          } else {
            additionalEmails.style.display = "none";
            moreBtn.innerText = "More";
          }
        }
      </script>
    </div>
  </div>
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
</body>

</html>