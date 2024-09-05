<?php
session_start(); // Start the session at the beginning of the script
require __DIR__ . '/../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email_id = $_POST['email_id'];
  $password = $_POST['password'];

  $sql = "SELECT id, password FROM user WHERE email_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      // Set session variables
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['email_id'] = $email_id;
      // Redirect back to product page
      header("Location: ../Product/AddProduct/product.php");
      exit();
    } else {
      echo "<script>alert('Invalid password.');</script>";
    }
  } else {
    echo "<script>alert('Email ID not found.');</script>";
  }

  $stmt->close();
  $conn->close();
}
?>