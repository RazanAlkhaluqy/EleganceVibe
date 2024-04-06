<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Designer Homepage</title>
       <link href="Designer.css" rel="stylesheet" type="text/css">
       
</head>
<body>
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
//$_SESSION['userId']="2";
// $_SESSION['userType'] = 'designer';
// 
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != 'designer') {
    header('Location: index.php');
    exit;
}




    if (!isset($_SESSION['userId'])) {
        header('Location: login.php');
        exit;
    }

    $designerId = $_SESSION['userId'];

    // Designer Information
    $query = "SELECT * FROM Designer WHERE id = $designerId";
    $result = mysqli_query($conn, $query);
    $designerInfo = mysqli_fetch_assoc($result);

    // Project Portfolio
    $query = "SELECT * FROM DesignPortoflioProject WHERE designerID = $designerId";
    $result = mysqli_query($conn, $query);

    // Design Consultation Requests
    $query = "SELECT dr.*, c.firstName as clientFirstName, c.lastName as clientLastName, dc.category as designCategory, r.type as roomType
              FROM DesignConsultationRequest dr
              JOIN Client c ON dr.clientID = c.id
              JOIN DesignCategory dc ON dr.designCategoryID = dc.id
              JOIN RoomType r ON dr.roomTypeID = r.id
              WHERE dr.designerID = $designerId AND dr.statusID = 1";
    $consultationRequests = mysqli_query($conn, $query);
    
    if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;}



    ?>
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
      <div class="mainContent">
          
    <h1>Welcome, <?php echo $designerInfo['firstName'] . " " . $designerInfo['lastName']; ?></h1>


    <p> <a  id="logout" href="designer.php?logout=1" style=" ">Sign Out  </a> </p>
        
      

     <h2>Designer Information</h2>
    <table>
        <tbody><tr>
            <th>Name</th>
            <td> <?php echo $designerInfo['firstName'] . " " . $designerInfo['lastName']; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo "<a href='mailto':{$designerInfo["emailAddress"]}>  {$designerInfo["emailAddress"]} </a>"; ?></td>
        </tr>
        <tr>
            <th>Brand Name </th>
            <td> <?php echo $designerInfo['brandName'] ; ?> </td>
       
    </tr>
       <tr>
            <th>logo </th>
            <td> <?php echo "<img src='image/{$designerInfo['logoImgFileName']}' alt='{$designerInfo['logoImgFileName']}' width='120'>"; ?> </td>

    </tr>
        <tr>
            <th>Speciality </th>
           
        <?php
 
  echo "<td>";
$query9 = "SELECT dc.category
          FROM designerspeciality ds
          JOIN designcategory dc ON ds.designCategoryID = dc.id
          WHERE ds.designerID = ?";
$stmt1 = $conn->prepare($query9);


$stmt1->bind_param("i", $designerId); 

$stmt1->execute();
$result9 = $stmt1->get_result();

while ($category = $result9->fetch_assoc()) {
    echo $category['category'] . "<br>";
}
    echo "</td>";
    echo "</tr>";
    ?>
   
    </tr>
    

        </tbody></table>
     </br>
     <p><a href="addition.php">Add New Project</a></p>
 

    <!-- Project Portfolio -->
    <h2>Project Portfolio</h2>
    <table>
        <tr>
            <th>Project Name</th>
            <th>Image</th>
            <th>Design Category</th>
            <th>Description</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        while ($project = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $project['projectName'] . "</td>";
            echo "<td><img src='image/" . $project['projectImgFileName'] . "' alt='Project Image' width='100'></td>";
            echo "<td>" . $project['designCategoryID'] . "</td>";
            echo "<td>" . $project['description'] . "</td>";
            echo "<td><a href='Update.php?Edit=" . $project['id'] . "'>Edit</a></td>";
            echo "<td><a href='deleteProject.php?Remove=" . $project['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
   
    <!-- Design Consultation Requests -->
    <h2>Design Consultation Requests</h2>
    <table>
        <tr>
            <th>Client Name</th>
            <th>Room Type</th>
            <th>Room Dimensions</th>
            <th>Design Category</th>
            <th>Color Preferences</th>
            <th>Date of Request</th>
            <th>Provide Consultation</th>
            <th>Decline Consultation</th>
        </tr>
        <?php
        while ($request = mysqli_fetch_assoc($consultationRequests)) {
            echo "<tr>";
            echo "<td>" . $request['clientFirstName'] . " " . $request['clientLastName'] . "</td>";
            echo "<td>" . $request['roomType'] . "</td>";
            echo "<td>" . $request['roomWidth'] . " x " . $request['roomLength'] . "</td>";
            echo "<td>" . $request['designCategory'] . "</td>";
            echo "<td>" . $request['colorPreferences'] . "</td>";
            echo "<td>" . date('d-m-Y', strtotime($request['date'])) . "</td>";
            echo "<td><a href='consultation.php?request_id=" . $request['id'] . "'>Provide Consultation</a></td>";
            echo "<td><a href='declineCon.php?decline=" . $request['id'] . "'>Decline Consultation</a></td>";
            echo "</tr>";
        }
        ?>
        
    </table>
</div>
    </br>  </br> 
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
               ©2024 Elegance Vibe
           </p>
       </div>
   </div>
</footer>


</body>
</html>
