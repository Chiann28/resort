<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css">


    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .room-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
            padding: 30px;
        }

        .room-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .room-card img {
            width: 100%;
            height: auto;
        }

        .room-card .card-body {
            padding: 20px;
        }

        .room-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .room-card p {
            font-size: 16px;
            color: #555;
        }

        .room-card .price {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }

        
    </style>
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

            echo '<div class="card room-card">';
            echo '<h3>' . $row['room_number'] . '</h3>';
            echo '<p>' . $row['description'] . '</p>';
            echo '</br>';
            echo '<p>Price: ₱ ' . $row['price'] . '</p>';
            echo '</br>';
            echo '<p><i class="bi bi-fan"></i> Airconditioned</p>';
            echo '<p><i class="bi bi-car-front-fill"></i> Free Parking</p>';
            echo '<p><i class="bi bi-cup-straw"></i> No Corkage Fee</p>';
            echo '<p><i class="bi bi-basket"></i> Non-inclusive of breakfast</p>';
            echo '<p><i class="bi bi-egg-fried"></i> Common Kitchen</p>';
            echo '<p><i class="bi bi-snow2"></i> Private Refrigerator and Water Dispenser</p>';
            echo '<p><i class="bi bi-tv-fill"></i> TV</p>';
            echo '<p><i class="bi bi-basket3-fill"></i> 2 Private Comfort Room</p>';
            echo '</br>';
            echo '</br>';
            echo '<p>Indulge in the serenity of the sea with our exquisite air-conditioned seaside unit. Perched along the coastline, this unit offers a unique and luxurious experience, combining the comfort of modern amenities with the beauty of ocean views.Indulge in the serenity of the sea with our exquisite air-conditioned seaside unit. Perched along the coastline, this unit offers a unique and luxurious experience, combining the comfort of modern amenities with the beauty of ocean views.</p>';
            echo '</div>';      
            echo '</div>';
            
            echo '<div class="col-md-6">';
            echo '<img src="../assets/img/rooms/' . $row['picture_link'] . '" alt="' . $row['room_number'] . '" class="img-fluid">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div style="text-align: center; margin-top:50px;">';
            echo '<img src="../assets/img/rooms/desc7.jpg" class="img-desc" style="height:500px; ">';
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