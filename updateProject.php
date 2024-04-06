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
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'designer') {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectId = $_GET['Edit']; // Get the project ID from the query string

    // Retrieve form data
    $projectName = $_POST['projectName'];
    $projectImage = $_FILES["newProjectImage"]['name']; // Retrieve new project image
    $designCategory = $_POST['designCategory'];
    $projectDescription = $_POST['projectDescription'];

    // File upload directory
    $targetDir = "image/";

    // Generate unique ID for filename
    $uniqueID = uniqid();

    // Get file extension
    $fileExtension = pathinfo($projectImage, PATHINFO_EXTENSION);

    // Construct new filename with unique ID
    $newFileName = $uniqueID . '.' . $fileExtension;

    // Target file path
    $targetFilePath = $targetDir . $newFileName;

    // Check if file already exists
    if (file_exists($targetFilePath)) {
        echo "Sorry, file already exists.";
    } else {
        // Upload file to server
        if (move_uploaded_file($_FILES["newProjectImage"]["tmp_name"], $targetFilePath)) {
            // Update project in the database with the new image
            $sql = "UPDATE DesignPortoflioProject SET projectName='$projectName', projectImgFileName='$newFileName', description='$projectDescription', designCategoryID='$designCategory' WHERE id='$projectId'";

            if (mysqli_query($conn, $sql)) {
                // Redirect to the designer's homepage
                header("Location: Designer.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>


