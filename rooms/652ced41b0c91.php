<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php

    require_once '../config.php';
    require 'navbar.php';
 
            
    // Create a database connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $currentFileName = __FILE__;

    $siteLink = basename($currentFileName, '.php') . '.php';


    // Query all rooms from the database
    $sql = "SELECT * FROM rooms where site_link = '$siteLink'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display room information for each row in a two-column layout
            echo '<div class="container" style="padding-top: 200px;">';
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<h3>' . $row['room_number'] . '</h3>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<p>Price: Php' . $row['price'] . '</p>';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<img src="../assets/img/rooms/' . $row['picture_link'] . '" alt="' . $row['room_number'] . '" class="img-fluid">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No rooms found.";
    }

    require 'footer.php';
?>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>