<?php
require __DIR__ . '/../db_connect.php';
// Ensure you have this file to connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $contact_number = $_POST['contact_number'];
  $email_id = $_POST['email_id'];
  // ... other fields
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Handle profile image upload
  $profile_image = $_FILES['profile_image']['name'];
  $target_dir = "../Singup/profile_images/";
  $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
  move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);

  // Insert data into the database
  $sql = "INSERT INTO user (first_name, last_name, profile_image, contact_number, email_id, password) VALUES (?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssss", $first_name, $last_name, $target_file, $contact_number, $email_id, $password);

  if ($stmt->execute()) {
    header("Location: ../login/login.html");
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>