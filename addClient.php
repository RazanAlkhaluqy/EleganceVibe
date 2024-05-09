<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "elegancevibe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM client WHERE emailAddress = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, redirect with error message
        header('Location: SignUP.php?error=emailtaken');
        exit();
    } else {
        // Insert new client
        $stmt = $conn->prepare("INSERT INTO client(firstName, lastName, emailAddress, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss",$firstName, $lastName, $email, $password);
        if ($stmt->execute()) {
            // Registration successful, set session variables
            $_SESSION['userId'] = $conn->insert_id;
            //echo $_SESSION['id'];
            $_SESSION['userType'] = "client";
            // Redirect to client homepage
            header('Location: Client.php');
           exit();
        } else {
            // Error in executing query
            header('Location: SignUP.php?error=stmtfailed');
            exit();
        }
    }
}

?>

