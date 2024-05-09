<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "elegancevibe";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in as a designer
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'designer') {
    header('Location: index.php'); // Redirect to the login page if not logged in as a designer
    exit;
}

// Initialize variables
$requestId = null;
$request = null;

// Check if a request ID is provided in the query string
if (isset($_GET['request_id'])) {
    // Sanitize the input
    $requestId = mysqli_real_escape_string($conn, $_GET['request_id']);
    
    // Retrieve request information based on the request ID
    $query = "SELECT dr.*, c.firstName as clientFirstName, c.lastName as clientLastName, dc.category as designCategory, r.type as roomType, dr.roomWidth, dr.roomLength, dr.colorPreferences, dr.date
    FROM DesignConsultationRequest dr
    JOIN Client c ON dr.clientID = c.id
    JOIN DesignCategory dc ON dr.designCategoryID = dc.id
    JOIN RoomType r ON dr.roomTypeID = r.id
    WHERE dr.id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the request details
        $request = $result->fetch_assoc();
    } else {
        echo "Request not found.";
        exit;
    }
} else {
    echo "Request ID not provided.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form data is valid
    if (isset($_POST['request_id'], $_POST['consultation'], $_FILES['photo'])) {
        $requestId = $_POST['request_id'];
        $consultation = $_POST['consultation'];
        
        // Handle file upload
        if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photoName = $_FILES['photo']['name'];
            $photoTmpName = $_FILES['photo']['tmp_name'];
            $photoType = $_FILES['photo']['type'];
            $photoSize = $_FILES['photo']['size'];

            // Generate a unique file name incorporating the request ID
            $uploadDir = "C:/MAMP/htdocs/EleganceVibe/image/"; 
            $uniqueFileName = uniqid() . '_' . $requestId . '_' . $photoName;
            $photoPath = $uploadDir . $uniqueFileName;

            // Move the uploaded file to the desired location
            if (move_uploaded_file($photoTmpName, $photoPath)) {
                // File uploaded successfully
                
                // Insert a new design consultation entry into the DesignConsultation table
                $insertQuery = "INSERT INTO DesignConsultation (requestID, consultation, consultationImgFileName) VALUES (?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                if (!$insertStmt) {
                    echo "Error: " . $conn->error;
                    exit;
                }
                $insertStmt->bind_param("iss", $requestId, $consultation, $uniqueFileName);
                $insertStmt->execute();
                if ($insertStmt->error) {
                    echo "Error: " . $insertStmt->error;
                    exit;
                }
            } else {
                // File upload failed
                echo "Failed to upload file.";
                exit;
            }
        } else {
            // Handle file upload errors
            echo "Error uploading file.";
            exit;
        }

        // Update the status of the request in the database to "consultation provided"
        $updateQuery = "UPDATE DesignConsultationRequest SET statusID = 3 WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        if (!$updateStmt) {
            echo "Error: " . $conn->error;
            exit;
        }
        $updateStmt->bind_param("i", $requestId);
        $updateStmt->execute();
        if ($updateStmt->error) {
            echo "Error: " . $updateStmt->error;
            exit;
        }

        // Redirect to the designer's homepage
        header("Location: Designer.php");
        exit();
    } else {
        echo "Invalid form data.";
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Design Consultation</title>
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
                    <li><a href="Designer.php">Designer</a></li>
                    <li><a href="addition.php">AddProject</a></li>
                </ul>
                <div class="mobile-menu-icon">☰</div>
            </nav>
        </div>
    </div>
</header>  
<br>
<h1 class="header">Design Consultation page</h1>
<section class="mainContent">
    <!-- Display request information -->
    <?php if ($request): ?>
        <h2>Design Consultation Request Details</h2>
        <br>
        <p><strong>Client Name:</strong> <?php echo $request['clientFirstName']. " " .$request['clientLastName'] ; ?></p>
        <br>
        <p><strong>Room Type:</strong> <?php echo $request['roomType']; ?></p>
        <br>
        <p><strong>Design Category:</strong> <?php echo $request['designCategory']; ?></p>
        <br>
        <p><strong>Dimensions: </strong><?php echo $request['roomWidth']. "x" .$request['roomLength']; ?></p>
        <br>
        <p><strong>Color Preferences: </strong><?php echo $request['colorPreferences']; ?></p>
        <br>
        <p><strong>Date of Request:</strong> <?php echo date('d-m-Y', strtotime($request['date'])); ?></p>
    <?php endif; ?>
    <hr>
    <!-- Consultation form -->
    <h2>Provide Consultation</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="request_id" value="<?php echo $requestId; ?>">
        <label for="consultation"><strong>Consultation:</strong></label><br>
        <textarea id="consultation" name="consultation" rows="4" cols="50"></textarea><br>
        <br>
        <label for="photo"><strong>Upload Photo:</strong></label><br>
        <input type="file" id="photo" name="photo"><br>
        <input type="submit" id="con1" value="Submit" id="submit">
    </form>
</section>

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

<?php
// Close connection
$conn->close();
?>

<?php
// Close connection
$conn->close();
?>









