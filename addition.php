<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
      <link href="addition.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
</head>
<body>
            <?php
      error_reporting(E_ALL);

ini_set('log_errors','1');

ini_set('display_errors','1');
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
}?>

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
             <li><a href="addition.php">AddProject</a></li>
             

                   </ul>
                   <!-- Add a button for the mobile menu -->
                   <div class="mobile-menu-icon">☰</div>
               </nav>
               
           </div>
       </div>
   </header>
   <br>
       <div class="container">
    <h1>Add New Project</h1>
    <form action="add_project.php" method="post" enctype="multipart/form-data">
        <label for="projectName">Project Name:</label>
        <input type="text" name="projectName" id="projectName" required><br>

        <label for="projectImgFileName">Project Image:</label>
        <input type="file" name="projectImgFileName" id="projectImgFileName" required><br>

        <label for="designCategoryID">Design Category:</label>
        <select name="designCategoryID" id="designCategoryID" required>
            <?php
            $query = "SELECT * FROM DesignCategory";
            $result = mysqli_query($conn, $query);
            while ($category = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $category['id'] . "'>" . $category['category'] . "</option>";
            }
            ?>
        </select><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="4" cols="50" required></textarea><br>

        <input type="submit" value="Add Project">
        
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
