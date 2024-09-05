<?php
// Database connection variables
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "cattledb"; // Replace with your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $cattle_id = $_POST['cattle_id'];
    $cattle_categories = $_POST['cattle_categories'];
    $cattle_breed = $_POST['cattle_breed'];
    $price = $_POST['price'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $description = $_POST['description'];

    // Handle cattle photo upload
    $target_dir = "uploads/"; // Ensure this directory exists and is writable
    $cattle_photo = $target_dir . basename($_FILES["cattle_photo"]["name"]);
    move_uploaded_file($_FILES["cattle_photo"]["tmp_name"], $cattle_photo);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO product (cattle_id, cattle_photo, cattle_categories, cattle_breed, price, age, weight, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdids", $cattle_id, $cattle_photo, $cattle_categories, $cattle_breed, $price, $age, $weight, $description);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the product page with a success message query parameter
        header('Location: product.php?success=true');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
