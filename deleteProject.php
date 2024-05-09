<?php

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

$response = array();

if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'designer') {
    $response['success'] = false;
    $response['message'] = 'Unauthorized access';
} else {
    // Get the project id from the URL parameter
    $projectId = isset($_GET['Remove']) ? intval($_GET['Remove']) : null;

    if ($projectId) {
        // Delete the project from the database
        $sql = "DELETE FROM designportoflioproject WHERE id = $projectId";
        if (mysqli_query($conn, $sql)) {
            $response['success'] = true;
            $response['message'] = 'Project deleted successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to delete project';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid project ID';
    }
}

// Close connection
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
