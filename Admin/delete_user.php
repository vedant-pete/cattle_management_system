<?php
// Connect to your database here
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "cattledb"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user ID is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Escape user input to prevent SQL injection
    $userId = $conn->real_escape_string($_GET['id']);

    // SQL query to delete user from the database
    $sql = "DELETE FROM user WHERE id = '$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
        // Redirect back to the admin panel after successful deletion
        header("Location: adminpanel.php");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid user ID.";
}

$conn->close();
?>