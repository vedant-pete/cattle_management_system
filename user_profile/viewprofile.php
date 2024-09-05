<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Prevent further execution
}

// Fetch user profile information from the database
$user_id = $_SESSION['user_id'];

// Database connection parameters
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "cattledb";

// Create connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch user profile data
$sql = "SELECT first_name, last_name, contact_number, email_id, profile_image FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query executed successfully
if (!$result) {
    die("SQL Error: " . $conn->error);
}

// Check if user profile data exists
if ($result->num_rows > 0) {
    // Fetch user profile data
    $row = $result->fetch_assoc();
    $first_name = $row["first_name"] ?? "Unknown";
    $last_name = $row["last_name"] ?? "Unknown";
    $contact_number = $row["contact_number"] ?? "Unknown";
    $email_id = $row["email_id"] ?? "Unknown";
    $profile_image = $row["profile_image"];
} else {
    // Handle case where user profile data is not found
    $first_name = "Unknown";
    $last_name = "Unknown";
    $contact_number = "Unknown";
    $email_id = "Unknown";
    $profile_picture = ""; // Default profile picture path
}

// Fetch cart data from the session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Initialize an empty array to store cart cattle information
$cart_cattle = [];

// Fetch information for each cattle in the cart
foreach ($cart as $cattle_id) {
    // SQL query to fetch cattle information based on cattle ID
    $sql = "SELECT * FROM product WHERE cattle_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cattle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query executed successfully
    if ($result->num_rows > 0) {
        // Fetch cattle information
        $row = $result->fetch_assoc();
        $cart_cattle[] = $row;
    }
    $stmt->close();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
        }

        .profile-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin: 20px auto;
            display: flex;
            border: 3px solid black;
            padding: 1px;
        }

        .profile-info strong {
            color: #333;
        }

        .profile-info p {
            font-size: 20px;
            margin: 10px 0;
            line-height: 1.6;
        }

        .section {
            float: left;
            width: 49%;
            box-sizing: border-box;
            padding: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 5px;
            text-align: center;
        }

        .section h2 {
            color: #4CAF50;
            margin-top: 0;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        a:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Welcome to Your Profile</h1>

    <div class="profile-container">
        <div>
            <?php if (!empty($profile_image)): ?>
                <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="profile-photo">
            <?php else: ?>
                <p>No profile picture available</p>
            <?php endif; ?>
        </div>

        <div class="profile-info">
            <p><strong>Name:</strong> <?php echo $first_name . ' ' . $last_name; ?></p>
            <p><strong>Mo. No.:</strong> <?php echo $contact_number; ?></p>
            <p><strong>Email ID:</strong> <?php echo $email_id; ?></p>
            <a href="../Product\AddProduct\logout.php">Logout</a>
            <a href="../Product\AddProduct\addproduct.html">Add Cattle</a>
        </div>
    </div>

    <div>
        <div class="section">
            <h2>Your Cart</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Breed</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cart_cattle as $cattle): ?>
                    <tr>
                        <td><?php echo $cattle['cattle_id']; ?></td>
                        <td><?php echo $cattle['cattle_breed']; ?></td>
                        <td>$<?php echo $cattle['price']; ?></td>
                        <td>
                            <button onclick="removeFromCart('<?php echo $cattle['cattle_id']; ?>')">Remove</button>
                            <button onclick="buyNow('<?php echo $cattle['cattle_id']; ?>')">Buy Now</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="section">
            <h2>Your added cattle</h2>
            <!-- Add content for the "Your added cattle" section here -->
        </div>
    </div>

    <script>
        function removeFromCart(cattleId) {
            console.log("Removing cattle with ID: " + cattleId);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    console.log("Response from server: " + this.responseText);
                    // Reload the page after successful removal
                    location.reload();
                }
            };
            xhttp.open("POST", "remove_from_cart.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("cattle_id=" + cattleId);
        }

    </script>
</body>

</html>