<?php
session_start();

// Connect to MySQL database
$mysqli = new mysqli("localhost", "root", "root", "elegancevibe");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Check if category is set in POST data
if (isset($_POST['category'])) {
    $selected_category = $_POST['category'];
    // Get designers by selected category
    $designers_query = $mysqli->query("SELECT d.*, GROUP_CONCAT(dc.category) AS specialities
                                        FROM Designer d
                                        JOIN DesignerSpeciality ds ON d.id = ds.designerID
                                        JOIN DesignCategory dc ON ds.designCategoryID = dc.id
                                        WHERE dc.category = '$selected_category'
                                        GROUP BY d.id");

    // Prepare JSON response
    $designers = array();
    while ($row = $designers_query->fetch_assoc()) {
        $designers[] = $row;
    }
    echo json_encode($designers);
} else {
    echo "Error: Category not provided.";
}
?>


