<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cattledb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, first_name, last_name, contact_number, email_id FROM user";
$result = $conn->query($sql);

$product_sql = "SELECT cattle_id, cattle_categories, cattle_breed, price, age, weight FROM product";
$product_result = $conn->query($product_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      padding: 20px;
    }

    .container {
      /* max-width: 800px; */
      /* margin: 0 auto; */
      width: 100%;
      height: 100%;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      display: flex;
      justify-content: space-around;
    }

    .container-left,
    .container-right {
      width: 50%;
      height: 100%;
      border: 2px solid black;
    }

    .container-left {
      margin-right: 20px;
    }

    h2 {
      text-align: center;
    }

    p {
      margin-bottom: 20px;
    }

    .logout-btn {
      display: block;
      width: 100px;
      margin: 20px auto;
      background-color: #ff5722;
      color: white;
      padding: 10px;
      text-align: center;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      position: absolute;
      right: 30px;
      top: 25px;
    }

    .logout-btn:hover {
      background-color: #e64a19;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    .delete-btn {
      background-color: #f44336;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 8px 12px;
      cursor: pointer;
    }

    .delete-btn:hover {
      background-color: #d32f2f;
    }

    .profile-info {
      display: flex;
      align-items: center;
    }

    .profile-info img {
      width: 40px;
      /* Adjust size as needed */
      height: 40px;
      /* Adjust size as needed */
      border-radius: 50%;
      /* To make it round */
      margin-right: 10px;
    }

    .profile-info .username {
      font-weight: bold;
    }

    .add-user-btn {
      display: block;
      width: 100px;
      margin: 20px auto;
      background-color: #ff5722;
      color: white;
      padding: 10px;
      text-align: center;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      position: absolute;
      right: 170px;
      top: 25px;
    }
  </style>
</head>

<body>
  <div class="navbar">
    <div class="profile-info">
      <img src="../img/man.png" alt="Profile Photo">
      <span class="username">Admin</span>
    </div>
    <h2>Welcome to Admin Panel</h2>
    <a href="../Product/AddProduct/addproduct.html" class="add-user-btn ">Add Cattle</a>
    <a href="../index.html" class="logout-btn">Logout</a>
  </div>
  <div class="container">

    <div class="container-left">
      <h2>Users</h2>
      <table>
        <thead>
          <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>{$row['id']}</td>";
              echo "<td>{$row['first_name']}</td>";
              echo "<td>{$row['last_name']}</td>";
              echo "<td>{$row['contact_number']}</td>";
              echo "<td>{$row['email_id']}</td>";
              echo "<td><button class='delete-btn' onclick='deleteUser({$row['id']})'>Block User</button></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No users found</td></tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>

    <div class="container-right">
      <h2>Cattle</h2>
      <table>
        <thead>
          <tr>
            <th>Cattle ID</th>
            <th>Category</th>
            <th>Breed</th>
            <th>Price</th>
            <th>Age</th>
            <th>Weight</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($product_result->num_rows > 0) {
            while ($row = $product_result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>{$row['cattle_id']}</td>";
              echo "<td>{$row['cattle_categories']}</td>";
              echo "<td>{$row['cattle_breed']}</td>";
              echo "<td>{$row['price']}</td>";
              echo "<td>{$row['age']}</td>";
              echo "<td>{$row['weight']}</td>";
              echo "<td><button class='delete-btn' onclick='deleteCattle({$row['cattle_id']})'>Remove</button></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No cattle found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>


  <script>
    function deleteUser(userId) {
      if (confirm("Are you sure you want to remove this user?")) {
        window.location.href = "delete_user.php?id=" + userId;
      }
    }
    function deleteCattle(cattleId) {
      if (confirm("Are you sure you want to remove this cattle?")) {
        // Redirect to PHP script to delete cattle
        window.location.href = "delete_cattle.php?id=" + cattleId;
      }
    }
  </script>
</body>

</html>