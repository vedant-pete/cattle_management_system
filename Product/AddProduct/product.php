<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
  $buttonText = 'Profile';
  $buttonAction = 'openProfilePopup()'; // JavaScript function to open the profile popup
} else {
  $buttonText = 'Click me for Login/Register';
  $buttonAction = 'openPopup()'; // JavaScript function to open the login/register popup
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Card</title>
  <!-- Add FontAwesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
      color: black;
      background-color: white;
    }

    nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      /* Distribute items along the main axis */
      gap: 1rem;
      border: 3px solid #8364e6;
      border-radius: 8px;
      padding: 10px;
    }


    #nav-logo img {
      width: 15rem;
      height: auto;

    }

    nav ul {
      display: flex;
      gap: 2rem;
      list-style: none;
      margin-left: auto;
      /* Push items to the right */
    }

    nav a {
      text-decoration: none;
      cursor: pointer;
    }

    /* Search box */
    #search-form {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 20px;
    }

    #search-form input {
      padding: 5px;
      margin-right: 10px;
      border: 2px solid #ccc;
      border-radius: 15px;
      width: 30rem;
      height: 2rem;
      text-align: center;
    }

    #search-form button {
      border: none;
      cursor: pointer;
      transition: 0.1s;
    }

    #add-product-button {
      padding: 5px;
      border: none;
      cursor: pointer;
      font-size: 17px;
      background-color: #4caf50;
      color: white;
      border-radius: 20px;
      position: absolute;
      right: 30px;
      height: 40px;
      width: 140px;
    }

    #search-form button:hover,
    #add-product-button:hover {
      opacity: 0.7;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
    }

    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      width: 23%;
      /* Adjust card width for 4 in a row */
      margin-bottom: 20px;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .container {
      padding: 2px 16px;
    }

    nav ul {
      gap: 1rem;
    }

    nav a {
      font-weight: bold;
    }

    /* Card container enhancements */
    .card-container {
      gap: 1rem;
      /* Add space between cards */
      padding: 1rem;
      /* Padding around the container */
    }

    /* Card styling */
    .card {
      background-color: white;
      /* Card background */
      border-radius: 8px;
      /* Rounded corners for cards */
      overflow: hidden;
      /* Hide overflow for rounded corners */
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      width: 23%;
      /* Adjust as needed */
      height: 100%;
      /* Fixed height for the card container */
      margin-bottom: 20px;
    }

    .card img {
      width: 100%;
      /* Ensure the image takes the full width of the card */
      height: 250px;
      /* Fixed height for the card */
      object-fit: cover;
      /* Cover the card area without stretching */
    }

    .container {
      padding: 1rem;
      /* Padding inside the card */
    }

    /* Typography and content styling */
    .container h4,
    .container p {
      margin-bottom: 0.5rem;
      /* Spacing between elements */
    }

    .container p {
      color: #555;
      /* Dark grey color for text */
    }

    /* Button styling */
    #add-product-button {
      background-color: #f9a825;
      /* A vibrant color for the button */
      position: fixed;
      /* Fixed position to keep it visible */
      bottom: 30px;
      /* Position from the bottom */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      /* Shadow for depth */
    }

    #add-product-button:hover {
      background-color: #4CAF50;

      /* Lighter shade on hover */
    }

    /* Add these styles inside your <style> tag */
    .card-button {
      display: inline-block;
      width: 48%;
      /* Adjusted width */
      padding: 10px;
      margin-top: 10px;
      margin-right: 2%;
      /* Space between buttons */
      border: none;
      border-radius: 5px;
      color: black;
      cursor: pointer;
      text-align: center;
      /* Center the text inside the buttons */
    }

    .add-to-cart-button {
      background-color: #f0ad4e;
      /* Orange color for Add to Cart */
    }

    .buy-now-button {
      background-color: #5cb85c;
      /* Green color for Buy Now */
    }

    .popup-overlay {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);

    }

    .popup-content {
      background-color: #fefefe;
      padding: 20px;
      border: 1px solid #888;
      width: 20%;
      border-radius: 10px;
      position: absolute;
      right: 23px;
      top: 85px;
      text-align: center;
    }

    .close-btn {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    /* Button styles */
    .popup-button {
      padding: 10px 20px;
      margin: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .login-btn,
    .signout-btn {
      background-color: #4CAF50;
      color: white;
      margin: 30px 19px;

    }

    /* -----pop up windows style */
    /* Styling for the popup button */
    #popupButton {
      color: black;
      width: 13rem;
      height: 30px;
      border-radius: 10px;
      border: 3px solid grey;
      background-color: white;
      cursor: pointer;
    }

    #popupButton:hover {
      border: 3px solid black;
      background-color: grey;
      color: white;
    }

    .login-register-button {
      /* Styles for the Login/Register button */
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      background-color: #4CAF50;
      color: white;
    }

    .profile-button {
      /* Styles for the Profile button */
      border: none;

    }

    .authButton>img {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="header">
    <nav>
      <div id="nav-logo">
        <img src="../../img/navlogo.png" alt="Logo" />
      </div>
      <ul>
        <li><a href="../../index.html#home">Home</a></li>
        <li><a href="../../index.html#about-cms">About</a></li>
        <li><a href="../../index.html#contact">Contact</a></li>
      </ul>
      <button id="authButton"
        class="<?php echo isset($_SESSION['user_id']) ? 'profile-button' : 'login-register-button'; ?>"
        onclick="<?php echo $buttonAction; ?>">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <?php echo $buttonText; ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): ?>
          <img src="../../img/user.png" alt="Profile" style="width: 50px; height: 50px;">
        <?php endif; ?>
      </button>

      <!-- <button id="add-product-button" onclick="redirectToaddcattlepage()">Add Product</button> -->
      <!-- <button id="popupButton">Click me for Login/Register</button> -->
    </nav>
  </div>
  <form id="search-form" onsubmit="event.preventDefault(); performSearch();">
    <input type="text" placeholder="Search by category..." id="search-input" />

    <button type="submit" id="search-button">
      <i class="fa fa-search" aria-hidden="true"></i>
    </button>
  </form>
  <button id="add-product-button" onclick="redirectToaddcattlepage()">Add Product</button>



  <div id="popup" class="popup-overlay">
    <!-- Popup content -->
    <div class="popup-content">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <p>Please choose an option:</p>
      <button class="popup-button login-btn" onclick="redirectToLoginPage()">Log In</button>
      <button class="popup-button signout-btn" onclick="redirectToSignupPage()">Sign up</button>
      <P>If You are admin <a href="../../Admin/admin.html" style="color:grey; text-decoration:none;">Click Here</a>
      </P>
    </div>
  </div>
  <!-- Profile Popup HTML -->
  <div id="profilePopup" class="popup-overlay" style="display: none;">
    <div class="popup-content">
      <span class="close-btn" onclick="closeProfilePopup()">×</span>
      <p>Please choose an option:</p>
      <button class="popup-button" onclick="redirectToViewProfile()">View Profile</button>
      <button class="popup-button" onclick="handleLogout()">Log Out</button>

    </div>
  </div>


  <div class=" card-container">
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

    // SQL query to fetch all products
    $sql = "SELECT * FROM product";
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
        echo '<p>Price: ₹ ' . $row["price"] . '</p>';
        echo '<p>Age: ' . $row["age"] . ' years</p>';
        echo '<p>Weight: ' . $row["weight"] . ' kg</p>';
        echo '<p>Description: ' . $row["description"] . '</p>';
        // Add to Cart Button
        echo '<button onclick="addToCart(\'' . $row["cattle_id"] . '\')" class="card-button add-to-cart-button">Add to Cart</button>';

        // Buy Now Button
        echo '<button onclick="buyNow(\'' . $row["cattle_id"] . '\')" class="card-button buy-now-button ">Buy Now</button>';
        echo '</div>';
        echo '</div>';
      }
    } else {
      echo "0 results";
    }


    // Close connection
    $conn->close();
    ?>
  </div>
  <!-- script -->
  <script>
    // JavaScript to hide the success message after 2 seconds
    setTimeout(function () {
      var successMsg = document.getElementById('success-msg');
      if (successMsg) {
        successMsg.style.display = 'none';
      }
    }, 2000); // 2000 milliseconds = 2 seconds
  </script>

  <script>
    function redirectToaddcattlepage() {
      // Check if the user is logged in
      if (!<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
        // User is not logged in, redirect to login page
        window.location.href = "../../login/login.html";
      } else {
        // User is logged in, redirect to add product page
        window.location.href = "addproduct.html";
      }
    }

  </script>
  <script>
    function addToCart(cattleId) {
      // Check if the user is logged in
      <?php if (isset($_SESSION['user_id'])): ?>
        // User is logged in, proceed with adding to cart
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Handle successful response
              var response = xhr.responseText;
              // Display success message
              alert(response);
              // Optionally, you can update the UI to reflect the addition to the cart
            } else {
              // Handle error response
              console.error('Error:', xhr.status);
            }
          }
        };
        xhr.open('POST', 'addToCart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('cattle_id=' + encodeURIComponent(cattleId));
      <?php else: ?>
        // User is not logged in, redirect to the login page
        window.location.href = "../../login/login.html";
      <?php endif; ?>
    }
  </script>

  <script>
    // Function to open the popup
    function openPopup() {
      document.getElementById("popup").style.display = "block";
    }

    // Function to close the popup
    function closePopup() {
      document.getElementById("popup").style.display = "none";
    }
  </script>
  <script>
    // JavaScript to show the popup when the button is clicked
    document.getElementById("popupButton").addEventListener("click", function () {
      document.getElementById("popup").style.display = "block";
    });

  </script>
  <script>
    function redirectToLoginPage() {
      // Replace 'login.html' with the URL of your login page
      window.location.href = "../../login/login.html";
    }
    function redirectToSignupPage() {
      // Replace 'login.html' with the URL of your login page
      window.location.href = "../../Singup/Singup.html";
    }
  </script>
  <!-- ---------------------for searching purpose -->
  <script>
    function performSearch() {
      var category = document.getElementById('search-input').value;

      // Send AJAX request to search.php
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Update the card-container with search results
            document.querySelector('.card-container').innerHTML = xhr.responseText;
          } else {
            console.error('Error:', xhr.status);
          }
        }
      };
      xhr.open('GET', 'search.php?category=' + encodeURIComponent(category), true);
      xhr.send();
    }
  </script>
  <script>
    function redirectToProfilePage() {
      // Implement the redirection to the profile page
      window.location.href = 'profile.php'; // Replace 'profile.php' with the actual profile page URL
    }

    function openPopup() {
      // Implement the opening of the login/register popup
      document.getElementById('popup').style.display = 'block';
    }

    // function redirectToaddcattlepage() {
    //   // Implement the redirection to the add cattle page
    //   window.location.href = 'addcattle.html'; // Replace 'addcattle.php' with the actual add cattle page URL
    // }
  </script>
  <script>
    // JavaScript Functions
    function openProfilePopup() {
      document.getElementById('profilePopup').style.display = 'block';
    }

    // Function to close the profile popup
    function closeProfilePopup() {
      document.getElementById('profilePopup').style.display = 'none';
    }

    // Function to redirect to the view profile page
    function redirectToViewProfile() {
      // Replace 'viewprofile.php' with the actual URL of your view profile page
      window.location.href = '../../user_profile/viewprofile.php';
    }

    function handleLogout() {
      // Handle the logout process
      window.location.href = 'logout.php'; // Replace with your actual logout script URL
    }

  </script>
  <script>
    function handleLogout() {
      // Redirect to the logout.php script
      window.location.href = 'logout.php';
    }

  </script>
</body>

</html>