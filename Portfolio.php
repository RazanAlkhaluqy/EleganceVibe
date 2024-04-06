<?php
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('display_errors', '1');
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "elegancevibe";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if designer ID is provided in the query string
if (isset($_GET['designer_id'])) {
    $designerID = $_GET['designer_id'];

    // Retrieve designer's portfolio projects
    $sql = "SELECT p.projectName, p.projectImgFileName, c.category, p.description 
            FROM DesignPortoflioProject p 
            INNER JOIN DesignCategory c ON p.designCategoryID = c.id 
            WHERE p.designerID = '$designerID'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Designer ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Designer.css" rel="stylesheet" type="text/css">
    <title>Design Portfolio</title>
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
                    <li><a href="Portfolio.php">Portfolio</a></li>
                    <li><a href="Designer.php">Designer</a></li>
                </ul>
                <!-- Add a button for the mobile menu -->
                <div class="mobile-menu-icon">☰</div>
            </nav>
        </div>
    </div>
</header>

<div class="mainContent">
    <h2>Design Portfolio</h2>

    <table id="portfolio-table">
        <thead>
        <tr>
            <th>Project Name</th>
            <th>Image</th>
            <th>Design Category</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Fetch and display projects
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['projectName'] . "</td>";
            echo "<td><img src='image/" . $row['projectImgFileName'] . "' alt='" . $row['projectName'] . "' width='120' style='max-width: 100px; max-height: 100px;'></td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
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
