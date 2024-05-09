<?php
session_start();

// Connect to MySQL database
$mysqli = new mysqli("localhost", "root", "root", "elegancevibe");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Check if client ID is set in the session
if (!isset($_SESSION['userId'])) {
    echo "Error: client ID is not set in the session.";
    //  exit();
}

$id = $_SESSION['userId'];

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_category = $_POST['category'];
    // Get designers by selected category
    $designers_query = $mysqli->query("SELECT d.*, GROUP_CONCAT(dc.category) AS specialities
                                        FROM Designer d
                                        JOIN DesignerSpeciality ds ON d.id = ds.designerID
                                        JOIN DesignCategory dc ON ds.designCategoryID = dc.id
                                        WHERE dc.category = '$selected_category'
                                        GROUP BY d.id");
} else {
    // Get all designers
    $designers_query = $mysqli->query("SELECT d.*, GROUP_CONCAT(dc.category) AS specialities
                                        FROM Designer d
                                        JOIN DesignerSpeciality ds ON d.id = ds.designerID
                                        JOIN DesignCategory dc ON ds.designCategoryID = dc.id
                                        GROUP BY d.id");
}

// Retrieve consultation design requests for this client
$queryConsultationRequests = $mysqli->query("SELECT 
                                    d.brandName, 
                                    d.logoImgFileName, 
                                    rt.type AS roomType, 
                                    dcr.roomWidth, 
                                    dcr.roomLength, 
                                    dc.category AS designCategory, 
                                    dcr.ColorPreferences, 
                                    dcr.date, 
                                    rs.status, 
                                    dco.consultation, 
                                    dco.consultationImgFileName
                              FROM 
                                    DesignConsultationRequest dcr
                                    INNER JOIN Designer d ON dcr.designerID = d.id
                                    INNER JOIN RoomType rt ON dcr.roomTypeID = rt.id
                                    INNER JOIN DesignCategory dc ON dcr.designCategoryID = dc.id
                                    INNER JOIN RequestStatus rs ON dcr.statusID = rs.id
                                    LEFT JOIN DesignConsultation dco ON dcr.id = dco.requestID 
                              WHERE 
                                    dcr.clientID = '$id' ");

 if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Homepage</title>
    <link rel="stylesheet" href="client.css" type="text/css">
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
                        <li><a href="Client.php">Client</a></li>
                    </ul>
                    <!-- Add a button for the mobile menu -->
                    <div class="mobile-menu-icon">&#9776;</div>
                </nav>
            </div>
        </div>
    </header>
    <br> <br>
    <div class="mainContent"> 
        <p>
             <p> <a  id="logout" href="Client.php?logout=1" style="">Sign Out  </a> </p>
        </p>
        <section class="client-info-section" id="clientInfoSection">
            <?php  
            $client_query = $mysqli->query("SELECT firstName, lastName, emailAddress FROM Client WHERE id = $id");
            if($row = $client_query->fetch_assoc()) {
                echo "<section class=welcome-section id=welcomeSection>";
                echo "<h1>Welcome, " . $row['firstName'] .$id. "!</h1></section><br>";
                echo "Client's Information:<br>";
                echo "<table><th>Full Name: </th><td>" . $row['firstName'] . " " . $row['lastName'] . "</td></tr>";
                echo "<tr><th>Email: </th><td>" . $row['emailAddress'] . "</td></tr></table>";
            } else { 
                echo "Welcome ";    
            }   
            ?>
        </section>
        <br> 
        <!-- Form for filtering designers by category -->
       <!-- <form method="post" action="">
            <label for="category">Filter Designers by Category:</label>
            <select name="category" id="category">
                <?php
                // Retrieve all categories from the database
            /*    $categories_query = $mysqli->query("SELECT * FROM DesignCategory");
                while ($row = $categories_query->fetch_assoc()) {
                    echo "<option value='".$row['category']."'>".$row['category']."</option>";
                }
             */   ?>  
            </select>
            <input type="submit" value="Filter">
        </form>
        -->
        <label for="category">Filter Designers by Category:</label>
<select name="category" id="category">
    <?php
    // Retrieve all categories from the database
    $categories_query = $mysqli->query("SELECT * FROM DesignCategory");
    while ($row = $categories_query->fetch_assoc()) {
        echo "<option value='".$row['category']."'>".$row['category']."</option>";
    }
    ?>
</select>
        
        <!-- JavaScript for AJAX request -->
<script>
    document.getElementById('category').addEventListener('change', function() {
        var category = this.value;
        // Make an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Update the designers table with the received data
                    updateDesignersTable(JSON.parse(xhr.responseText));
                } else {
                    console.error('AJAX request failed.');
                }
            }
        };
        xhr.open('POST', 'filter_designers.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('category=' + encodeURIComponent(category));
    });

    function updateDesignersTable(data) {
    var tableBody = document.querySelector('#designersTable tbody');
    // Clear existing table rows
    tableBody.innerHTML = '';

    // Iterate over the received data and populate the table
    data.forEach(function(designer) {
        var row = '<tr>' +
            '<td><a href="portfolio.php?designer_id=' + designer.id + '">' +
            '<img src="image/' + designer.logoImgFileName + '" alt="' + designer.brandName + '" width="120">' +
            designer.brandName +
            '</a></td>' +
            '<td>' + designer.specialities + '</td>' +
            '<td><a href="request_consultation.php?designer_id=' + designer.id + '">Request Design Consultation</a></td>' +
            '</tr>';
        tableBody.innerHTML += row;
    });
}

</script>
        <!-- Display designers -->
        <h2>Designers:</h2>
        <table border="1" id="designersTable">
            <thead>
                <tr>
                    <th>Designer</th>
                    <th>Speciality</th>
                    <th>Request Design Consultation</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($designer = $designers_query->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <a href="portfolio.php?designer_id=<?php echo $designer['id']; ?>">
                                <img  src="image/<?php echo $designer['logoImgFileName']; ?>" alt="<?php echo $designer['brandName']; ?>" width='120' > <?php echo $designer['brandName']; ?>
                            </a>
                        </td>
                        <td><?php echo $designer['specialities']; ?></td>
                        <td><a href="request_consultation.php?designer_id=<?php echo $designer['id']; ?>">
                                Request Design Consultation</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Display consultation design requests for this client -->
        <h2>Your Consultation Requests:</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Designer Logo with Brand Name</th>
                    <th>Room Type</th>
                    <th>Room Dimensions</th>
                    <th>Design Category</th>
                    <th>Color Preferences</th>
                    <th>Date of Request</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    <?php while ($request = $queryConsultationRequests->fetch_assoc()): ?>
        <tr>
            <td>
                <img src="image/<?php echo $request['logoImgFileName']; ?>" 
                     alt="<?php echo $request['brandName']; ?>" width='120'> <?php echo $request['brandName']; ?>
            </td>
            <td><?php echo $request['roomType']; ?></td>
            <td><?php echo $request['roomWidth']." x ".$request['roomLength']; ?></td>
            <td><?php echo $request['designCategory']; ?></td>
            <td><?php echo $request['ColorPreferences']; ?></td>
            <td><?php echo $request['date']; ?></td>
            <td>
                <?php
                // Display consultation and image if provided
                if ($request['status'] == "Consultation Provided") {
                    // Display consultation and image
                    echo "<p>".$request['consultation']."</p><br>";
                    echo '<img src="image/' . $request['consultationImgFileName'] . '" alt="Consultation Image" width="120">';
                } elseif ($request['status'] == "Consultation Declined" || $request['status'] === "Pending Consultation") {
                    // Display status
                    echo $request['status'];
                }
                ?>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>
        </table>
    </section>
</div>  



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
