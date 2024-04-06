<?php
// Establish database connection
$connection = mysqli_connect("localhost", "root", "root", "elegancevibe");

if (mysqli_connect_error()) {
    die(mysqli_connect_error());
}

// Check if project ID is provided in the query string
if (isset($_GET['Edit'])) {
    $projectId = $_GET['Edit'];

    // Retrieve project information from the database
    $query = "SELECT * FROM designportoflioproject WHERE id='$projectId'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $project = mysqli_fetch_assoc($result);
    } else {
        echo "Project not found.";
        exit;
    }
} else {
    echo "Project ID not provided.";
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $projectId = $_POST['projectId'];
    $projectName = $_POST['projectName'];
    $projectImage = $_POST['projectImage'];
    $designCategory = $_POST['designCategory'];
    $projectDescription = $_POST['projectDescription'];

    // Update project in the database
    $query = "UPDATE DesignPortoflioProject SET projectName='$projectName', projectImgFileName='$projectImage', description='$projectDescription', designCategoryID='$designCategory' WHERE id='$projectId'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Redirect to the designer's homepage
        header("Location: Designer.php");
        exit;
    } else {
        echo "Error updating project: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Project</title>
    <link rel="stylesheet" href="Update.css" type="text/css">
    <link rel="stylesheet" href="addition.css" type="text/css">
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
             <li><a href="Update.php">UpdateProject</a></li>
             

                   </ul>
                   <!-- Add a button for the mobile menu -->
                   <div class="mobile-menu-icon">☰</div>
               </nav>
               
           </div>
       </div>
   </header>

    <h1>Update Project</h1>
    <div class="container">
         <form action="updateProject.php?Edit=<?php echo $projectId; ?>" method="post" enctype="multipart/form-data">

        <!-- Include a hidden input field for project ID -->
        <input type="hidden" name="projectId" value="<?php echo $project['id']; ?>">
        <label for="projectName">Project Name:</label>
        <input type="text" id="projectName" name="projectName" value="<?php echo $project['projectName']; ?>" required>
        <br>
        <!-- Display current project image URL and provide option to upload new image -->
        <label for="projectImage">Current Project Image URL:</label>
        <a href="image/<?php echo $project['projectImgFileName']; ?>"><?php echo $project['projectImgFileName']; ?></a>
        <input type="file" name="newProjectImage" id="newProjectImage" accept="image/*">

        <label for="designCategory">Design Category:</label>
        <select id="designCategory" name="designCategory" required>
            <option value="1" <?php if ($project['designCategoryID'] == 1) echo "selected"; ?>>Living Room</option>
            <option value="2" <?php if ($project['designCategoryID'] == 2) echo "selected"; ?>>Kitchen</option>
            <option value="3" <?php if ($project['designCategoryID'] == 3) echo "selected"; ?>>Office</option>
            <option value="4" <?php if ($project['designCategoryID'] == 4) echo "selected"; ?>>Bathroom</option>
        </select>

        <label for="projectDescription">Project Description:</label>
        <textarea id="projectDescription" name="projectDescription" required><?php echo $project['description']; ?></textarea>

        <button type="submit">Update Project</button>
    </form>
    </div>

   </br>    </br>
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
                   © 2024 Elegance Vibe
               </p>
           </div>
       </div>
   </footer>
</body>
</html>

