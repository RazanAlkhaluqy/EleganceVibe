<?php
session_start();
// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "elegancevibe";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $clientID = $_SESSION['userId'];
    $designerID = $_POST['designer_id'];
    $roomTypeID = $_POST['roomType'];
    $roomWidth = $_POST['roomWidth'];
    $roomLength = $_POST['roomLength'];
    $designCategoryID = $_POST['designCategory'];
    $colorPreferences = $_POST['colorPreferences'];
    $statusID = 1; // Pending consultation by default

    // Get current date
    $currentDate = date('Y-m-d'); 
    
    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO DesignConsultationRequest (clientID, designerID, roomTypeID, designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("iiiiisssi", $clientID, $designerID, $roomTypeID, $designCategoryID, $roomWidth, $roomLength, $colorPreferences, $currentDate, $statusID);

        if ($stmt->execute()) {
            // Close the statement
            $stmt->close();
            // Close database connection
            $conn->close();
            // Redirect to the client's homepage
            header("Location: client.php");
            exit();
        } else {
            die("Error executing prepared statement: " . $stmt->error);
        }
    } else {
        die("Error in prepared statement: " . $conn->error);
    }
}
?>



<!-- HTML part -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Design Consultation</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<header>
<div id="navbar">
           <div id="head">
            <a href="index.php"> <img src="image/logo.png" alt="logo" class="logo"> </a>
           </div>
             <div>
                <nav id="navbar-right">
                   <ul class="nav-list">
                     
             <li><a href="index.php">Homepage</a></li>
             <li><a href="Client.php">Client</a></li>
             

                   </ul>
                   <div class="mobile-menu-icon">☰</div>
               </nav>
               
           </div>
       </div>
</header>
<br>
<div class="mainContent2">
    <!-- Form for requesting design consultation -->
    <h1 class="header">Request Design Consultation Page</h1>
    <section class="req">
        <h2>Client's Design Consultation Request</h2>
        <hr>
        <br>
        <form id="designRequestForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
            // Check if designer id is provided in the query string
            if (isset($_GET['designer_id'])) {
                $designerId = $_GET['designer_id'];
                // Add designer id as hidden input in the form
                echo '<input type="hidden" name="designer_id" value="' . $designerId . '">';
            } else {
                // Redirect to homepage if designer id is not provided
                header("Location: index.php");
                exit();
            }
            ?>
            <label for="roomType">Room Type:</label>
            <select id="roomType" name="roomType" required="">
                <option value="1">Living Room</option>
                <option value="2" >Bed room</option>
                <option value="3">Office</option>
                <option value="4">Kitchen</option>
            </select>
            <br><br>
            <label for="roomWidth">Room Width (meters):</label>
            <input type="number" id="roomWidth" name="roomWidth" placeholder="Enter width" required="" min="1">
            <br><br>
            <label for="roomLength">Room Length (meters):</label>
            <input type="number" id="roomLength" name="roomLength" placeholder="Enter length" required="" min="1">
            <br><br>
            <label for="designCategory">Design Category:</label>
            <select id="designCategory" name="designCategory" required="">
                <option value="1">Modern</option>
                <option value="2">Vintage</option>
                <option value="3">Minimalist</option>
            </select>
            <br><br>
            <label for="colorPreferences">Color Preferences:</label>
            <input type="text" id="colorPreferences" name="colorPreferences" placeholder="Enter color preferences">
            <br><br>
            <button type="submit" class="f1">Send</button>
        </form>
    </section>
</div>
<footer>
<div id="footer">
        <p id="contact"> Contact Us  <br>
            Riaydh, Saudi Arabia <br>
            <a id="link" href="mailto: ContactUs@EleganceVibe.com"> ContactUs@EleganceVibe.com</a>
           </p>
       
       <div class="footer-sections">
           <div id="fot1">
               <br>
               <a href="" class="footer">About Elegance Vibe </a> <br>
               <a href="" class="footer">FAQ</a>
           </div>

          

           <div id="fot2">
               <br>
               <a href="" class="footer">Terms of Use</a><br>
                <a href="" class="footer">Privacy Policy</a>
           </div>
       </div>
       <div id="fot3">
          
           <p>
               <a href="" class="footer"><img src="image/whatsapp.png" alt="whatsapp"></a>
               <a href="" class="footer"><img src="image/twitter.png" alt="twitter"></a>
               <a href="" class="footer"><img src="image/instagram.png" alt="instagram"></a>
               <br> 
               ©2024 Elegance Vibe
           </p>
       </div>
   </div>
</footer>
</body>
</html>


