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
    // Retrieve form data
    print_r($_POST);
    print_r($_FILES);
    $designerID = $_SESSION['userId'];
    $projectName = $_POST['projectName'];
    $projectImgFileName = $_FILES["projectImgFileName"]['name'];
    $description = $_POST['description'];
    $designCategoryID = $_POST['designCategoryID'];

    // File upload directory
    $targetDir = "image/";

    // Generate unique ID for filename
    $uniqueID = uniqid();

    // Get file extension
    $fileExtension = pathinfo($projectImgFileName, PATHINFO_EXTENSION);

    // Construct new filename with unique ID
    $newFileName = $uniqueID . '.' . $fileExtension;

    // Target file path
    $targetFilePath = $targetDir . $newFileName;

    // Check if file already exists
    if (file_exists($targetFilePath)) {
        echo "Sorry, file already exists.";
    } else {
        // Upload file to server
        if (move_uploaded_file($_FILES["projectImgFileName"]["tmp_name"], $targetFilePath)) {
            // Insert new project into the DesignPortoflioProject table
            $sql = "INSERT INTO DesignPortoflioProject (designerID, projectName, projectImgFileName, description, designCategoryID) 
            VALUES ('$designerID', '$projectName', '$newFileName', '$description', '$designCategoryID')";

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


