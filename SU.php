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

// Check if form fields are set
if (isset($_POST['userType'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'])) {
    $userType = $_POST['userType'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $sql = "SELECT * FROM $userType WHERE emailAddress = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If Email already exists
        header('Location: SignUp.php?error=emailtaken');
        exit();
    } else {
        // Adding user to database
        if ($userType == "designer") {
            $fields = "firstName, lastName, emailAddress, password, brandName";
            $sql = "INSERT INTO designer ($fields) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $brandName = $_POST['brandName']; // Retrieve brandName separately
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $password, $brandName);
        } else {
            $fields = "firstName, lastName, emailAddress, password";
            $sql = "INSERT INTO client ($fields) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
        }

        if ($stmt->execute()) {
            // Signup successful, redirect
            $_SESSION['user_id'] = $stmt->insert_id; // To get the ID
            $_SESSION['user_type'] = $userType;

            if ($userType == "designer") {
                header('Location: Designer.php');
            } else {
                header('Location: Client.php');
            }
            exit();
        } else {
            // If Signup failed
            header('Location: SignUp.php?error=stmtfailed');
            exit();
        }
    }
} else {
    // Redirect if form fields are not set
    header('Location: SignUp.php');
    exit();
}

$stmt->close();
$conn->close();
?>
