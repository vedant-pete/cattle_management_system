<?php
session_start(); // Start the session

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>

<script>
    // Redirect to index.html using JavaScript
    window.location.href = '../../index.html';
</script>