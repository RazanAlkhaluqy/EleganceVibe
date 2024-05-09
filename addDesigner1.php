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
    $brandName = $_POST['brandName'];
    $logoFileName = $_FILES["logo"]["name"];
    $logoTempFilePath = $_FILES["logo"]["tmp_name"];
    $targetDirectory = 'image/' . $logoFileName;

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM designer WHERE emailAddress = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, redirect with error message
        header('Location: SignUP.php?error=emailtaken');
        exit();
    } else {
        // Insert new designer
        $stmt = $conn->prepare("INSERT INTO designer (firstName, lastName, emailAddress, password, brandName, logoImgFileName) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $password, $brandName, $logoFileName);

        if ($stmt->execute()) {
           
            move_uploaded_file($logoTempFilePath, $targetDirectory);

            // Get the designer ID
            $designer_id = $conn->insert_id;

            // Insert designer's specialties
            if (isset($_POST['spec'])) {
                $spec = $_POST['spec'];
                foreach ($spec as $speciality) {
                    
                    $stmt_category = $conn->prepare("SELECT id FROM designcategory WHERE category = ?");
                    $stmt_category->bind_param("s", $speciality);
                    if ($stmt_category->execute()) {
                        $result_category = $stmt_category->get_result();
                        if ($result_category->num_rows > 0) {
                            $row_category = $result_category->fetch_assoc();
                            
                            $category_id = $row_category['id'];
 
                            $stmt_speciality = $conn->prepare("INSERT INTO designerspeciality (designerID, designCategoryID) VALUES (?, ?)");
                            $stmt_speciality->bind_param("ii", $designer_id, $category_id);
                            $stmt_speciality->execute();
                        }
                    }
                }
            }

            // Set session variables and redirect
            $_SESSION['userId'] = $designer_id;
            $_SESSION['userType'] = "designer";
            header("Location: Designer.php");//last
            exit();
        } else {
            // Error handling for query execution failure
            // You can redirect to an error page or handle it as per your requirement
            echo "Error: " . $conn->error;
        }
    }
}
?>


