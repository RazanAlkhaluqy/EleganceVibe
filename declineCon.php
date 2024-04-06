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

if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'designer') {
    header('Location: index.php');
    exit;
}


// Get the request ID from the URL parameter
$requestId = isset($_GET['decline']) ? intval($_GET['decline']) : null;

if ($requestId) {
    // Update the status of the consultation request to "consultation declined"
    $status = "consultation declined";
    $updateQuery = "UPDATE DesignConsultationRequest SET statusID = (
        SELECT id FROM RequestStatus WHERE status = ?
    ) WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $status, $requestId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect back to the designer's homepage
        header('Location: designer.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn); // Handle database error if any
    }
} else {
    echo "Invalid request ID"; // Handle invalid request ID
}


?>

