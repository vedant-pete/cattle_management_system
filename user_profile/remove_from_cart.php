<?php
session_start();

// Check if the cattle ID is provided
if (isset($_POST['cattle_id'])) {
    // Get the cattle ID
    $cattleId = $_POST['cattle_id'];

    // Fetch the cart from the session
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    // Find the index of the cattle in the cart array
    $index = array_search($cattleId, $cart);

    // Check if the cattle is in the cart
    if ($index !== false) {
        // Remove the cattle from the cart array
        unset($cart[$index]);
        // Update the cart session variable
        $_SESSION['cart'] = $cart;
        // Return success response
        echo "success";
    } else {
        // Return error response if cattle is not found in cart
        echo "error: cattle not found in cart";
    }
} else {
    // Return error response if cattle ID is not provided
    echo "error: cattle ID not provided";
}
?>