<?php
session_start();

// Check if the cattle ID is provided
if (isset($_POST['cattle_id'])) {
    // Get the cattle ID from the request
    $cattle_id = $_POST['cattle_id'];

    // Add the cattle ID to the user's cart session variable
    $_SESSION['cart'][] = $cattle_id;

    // Return a success message or any relevant response
    echo "Cattle added to cart successfully!";
} else {
    // Return an error message if the cattle ID is not provided
    echo "Error: Cattle ID not provided!";
}
?>
