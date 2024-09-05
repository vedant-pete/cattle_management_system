<?php
// Check if cattle ID is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cattleId = $_GET['id'];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cattledb";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to delete cattle from product table
    $sql = "DELETE FROM product WHERE cattle_id = $cattleId";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the admin panel after successful deletion
        header("Location: adminpanel.php");
        exit();
    } else {
        echo "Error deleting cattle: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid cattle ID.";
}
?>