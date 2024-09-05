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

// Get the search category from the GET parameters
$search_category = isset($_GET['category']) ? $_GET['category'] : '';

// Check if the search category is empty
if (empty($search_category)) {
    die("No search category provided");
}

// SQL query to search for products by category
$sql = "SELECT * FROM product WHERE cattle_categories LIKE '%$search_category%'";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<img src="' . $row["cattle_photo"] . '" alt="Cattle" style="width:100%">';
        echo '<div class="container">';
        echo '<h4><b>ID: ' . $row["cattle_id"] . '</b></h4>';
        echo '<p>Breed: ' . $row["cattle_breed"] . '</p>';
        echo '<p>Category: ' . $row["cattle_categories"] . '</p>';
        echo '<p>Price: $' . $row["price"] . '</p>';
        echo '<p>Age: ' . $row["age"] . ' years</p>';
        echo '<p>Weight: ' . $row["weight"] . ' kg</p>';
        echo '<p>Description: ' . $row["description"] . '</p>';
        // Add to Cart Button
        echo '<button onclick="addToCart(\'' . $row["cattle_id"] . '\')" class="card-button add-to-cart-button ">Add to Cart</button>';
        // Buy Now Button
        echo '<button onclick="buyNow(\'' . $row["cattle_id"] . '\')" class="card-button buy-now-button ">Buy Now</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No results found";
}

// Close connection
$conn->close();
?>