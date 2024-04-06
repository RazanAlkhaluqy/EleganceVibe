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
// Get the project id from the URL parameter
$projectId = isset($_GET['Remove']) ? intval($_GET['Remove']) : null;

if ($projectId) {
    // Delete the project from the database
    $sql = "DELETE FROM designportoflioproject WHERE id = $projectId";
    mysqli_query($conn, $sql);
        header('Location: designer.php');
}

?>

