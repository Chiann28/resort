<?php
// Start the session
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}


// Replace with your database connection details
// $servername = "localhost";
// $dbusername = "root";
// $dbpassword = "";
// $dbname = "hotel_management";

require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database to fetch data
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hotel Management and Reservation System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

<?php
    require 'admin_navbar.php';
?>

    <table class="room-table">
        <tr>
            <th>Room Number</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
            <!-- Add more table headers based on your database columns -->
        </tr>
        <?php
        // Loop through the query results and display data in the table rows
        $availability = '';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($row['status'] == '0'){
                    $availability = 'Available';
                }
                if($row['status'] == '1'){
                    $availability = 'Reserved';
                }
                if($row['status'] == '2'){
                    $availability = 'Occupied';
                }
                echo "<tr>";
                echo "<td>" . $row['room_number'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $availability . "</td>";
                echo "<td>";
                echo "<a class='edit-btn' onclick='openEditPopup(" . $row['room_number'] . ")'>Edit</a>";
                echo "<a href='delete_data.php?id=" . $row['room_number'] . "' onclick='return confirm(\"Are you sure you want to delete this item?\")'>Delete</a>";
                echo "</td>";
                // Add more table data based on your database columns
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
    <!-- The Edit Popup -->
<div id="editPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditPopup()">&times;</span>
        <h2>Edit Data</h2>
        <div id="editPopupContent">
            <!-- The content of the edit form will be loaded here using AJAX -->
        </div>
    </div>
</div>

<!-- JavaScript to handle the edit popup -->
<script>
    function openEditPopup(room_number) {
        // Get the editPopup element
        var editPopup = document.getElementById("editPopup");

        // Show the editPopup
        editPopup.style.display = "block";

        // Load the edit form content using AJAX
        var editPopupContent = document.getElementById("editPopupContent");
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                editPopupContent.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "edit_data.php?room_number=" + room_number, true);
        xhttp.send();
    }

    function closeEditPopup() {
        // Get the editPopup element
        var editPopup = document.getElementById("editPopup");

        // Hide the editPopup
        editPopup.style.display = "none";
    }
</script>
 
    <a href="logout.php">Logout</a>
</body>
</html>