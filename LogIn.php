<?php
// Start the session
session_start();

// Database connection details
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    // Perform authentication and redirect based on the user type
    if ($userType === 'designer') {
        // Perform authentication logic for designer login
        // Replace the placeholder code with your actual authentication logic
        $sql = "SELECT * FROM designer WHERE emailAddress = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            // Authentication successful, set session variables and redirect to the designer homepage
            $row = mysqli_fetch_assoc($result);
            $_SESSION['userId'] = $row['id'];
            $_SESSION['userType'] = 'designer';
            header('Location: Designer.php');
            exit;
        }
    } elseif ($userType === 'client') {
        // Perform authentication logic for client login
        // Replace the placeholder code with your actual authentication logic
        $sql = "SELECT * FROM client WHERE emailAddress = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            // Authentication successful, set session variables and redirect to the client homepage
            $row = mysqli_fetch_assoc($result);
            $_SESSION['userId'] = $row['id'];
            $_SESSION['userType'] = 'client';
            header('Location: Client.php');
            exit;
        }
    }

    // Invalid login or incorrect password, redirect back to the login page with an error message
    header('Location: Log-In.php?error=1');
    exit;
} else {
    // Redirect back to the login page if the form is not submitted
    header('Location: Log-In.php');
    exit;
}

// Close the database connection
mysqli_close($conn);