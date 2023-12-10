<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hotel Management and Reservation System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- local css -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

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
  <style>
      .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; 
}

.form-container,
.amenities-container {
    width: 50%; 
    padding: 20px;
    background-color: #ffffff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    
}

 

      .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
      }

      
      .form-group {
        margin-bottom: 15px;
      }

      .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
      }

      .form-group input[type="date"],
      .form-group button[type="submit"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
      }

      /* Submit button */
      .form-group button[type="submit"] {
        background-color: #4CAF50;
        color: #ffffff;
        cursor: pointer;
        transition: background-color 0.3s;
      }

      .form-group button[type="submit"]:hover {
        background-color: #45a049;
      }
      .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            }
            .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            }
            .btn-primary:hover,
            .btn-danger:hover {
            filter: brightness(90%);
            }
      
</style>

</head>
<body>

<input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>K<span>amantigue</span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(admin.jpg)"></div>
                <h4>Admin</h4>
                <small>admin</small>
            </div>

            <div class="side-menu">
              <ul>
                  <li>
                     <a href="admin_dashboard.php" >
                          <span class="las la-home"></span>
                          <small>Dashboard</small>
                      </a>
                  </li>
                  <li>
                     <a href="room_list.php" >
                          <span class="las la-boxes"></span>
                          <small>Room List</small>
                      </a>
                  </li>
                  <li>
                     <a href="services_list.php" >
                          <span class="lab la-servicestack"></span>
                          <small>Services</small>
                      </a>
                  </li>
                  <li>
                     <a href="cashier_module.php">
                          <span class="las la-clipboard-list"></span>
                          <small>Cashier Module</small>
                      </a>
                  </li>
                  <li>
                     <a href="checkout_list.php">
                          <span class="las la-clipboard-list"></span>
                          <small>Check Out</small>
                      </a>
                  </li>
                  <li>
                     <a href="reservation_list.php">
                          <span class="las la-clipboard-list"></span>
                          <small>Reservations</small>
                      </a>
                  </li>
                  <li>
                     <a href="add_new_reservations.php" class="active">
                          <span class="las la-clipboard-list"></span>
                          <small>New Reservation</small>
                      </a>
                  </li>
                  <li>
                     <a href="admin_users.php">
                          <span class="las la-user-friends"></span>
                          <small>User List</small>
                      </a>
                  </li>
                  <li>
                     <a href="manage_promocode.php">
                          <span class="las la-tasks"></span>
                          <small>Promo Code</small>
                      </a>
                  </li>

                  <li>
                    <a href="reports.php">
                         <span class="las la-tasks"></span>
                         <small>Reports</small>
                     </a>
                 </li>

                  <li>
                    <a href="https://premium121.web-hosting.com:2096/cpsess6146287962/3rdparty/roundcube/index.php?_task=mail&_mbox=INBOX">
                         <span class="las la-envelope"></span>
                         <small>Inquiries</small>
                     </a>
                 </li>

              </ul>
          </div>
      </div>
  </div>

  <div class="main-content">
    <header>
        <div class="header-content">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>
            
            <div class="header-menu">
                <label for="">
                    <span></span>
                </label>
                
                <div class="notify-icon">
                    <span></span>
                    <span class="notify"></span>
                </div>
                
                <div class="notify-icon">
                    <span></span>
                    <span class="notify"></span>
                </div>
                
                <div class="user">
                    <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                    
                    <span class="las la-power-off"></span>
                    <a class="nav-link" href="logout.php"><span>Logout</span></a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="page-header" style="display: flex; align-items: center; margin-top: -50;">
            <h1 style="margin-right: 10px;">Add new reservation</h1>
            <br>
                <small>Home / Add new reservation</small>
            </div>
    <div class="container">
    <div class="form-container">
    <form action="new_booking.php" method="post">
    
      <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" style="width:590px;" required>
    </div>

    <div class="form-group">
      <label for="address">Address:</label>
      <input type="text" id="address" name="address" style="width:590px;" required>
    </div>

    <div class="form-group">
      <label for="check_in_date">Check-in Date:</label>
      <input type="date" id="check_in_date" name="check_in_date" onchange="updateCheckOutMin()" required>
    </div>

    <div class="form-group">
      <label for="check_out_date">Check-out Date:</label>
      <input type="date" id="check_out_date" name="check_out_date" required>
    </div>

    <?php
    require 'config.php';

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlRooms = "SELECT room_id, room_number, description FROM rooms";
    $resultRooms = $conn->query($sqlRooms);
    ?>
    <div class="form-group">
    <label for="room_type">Room Type:</label>
    <select class="form-control" id="room_type" name="room_type">
        <?php
        if ($resultRooms->num_rows > 0) {
            while ($roomRow = $resultRooms->fetch_assoc()) {
                echo "<option value='{$roomRow['room_id']}'>{$roomRow['room_number']} - {$roomRow['description']}</option>";
            }
        } else {
            echo "<option value=''>No rooms available</option>";
        }
        ?>
    </select>
    <br>
    <div class='cart-item'>Room Price:   Php / Night</div>
    <br>                  
    <div class="form-group">
      <label for="adults">Number of adults:</label>
      <input type="number" id="adults" name="adults" required>
    </div>

    <div class="form-group">
      <label for="children">Number of Children:</label>
      <input type="number" id="children" name="children" required>
    </div>
    <div class="form-group">
      <label for="children">Age of Children:</label>
      <input type="number" id="age" name="age" required>
    </div>

    <div class='cart-item'><b>Total Price: Php</b></div>
  </div>
  <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal'>Add Amenities</button>

        <br>
  <button class="btn btn-primary">Proceed to Payment</button>
</div>
 
                                        
                                            
    
  </form>
  

</div>
<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document' style="max-width:100%; width:50%;">
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Reservation Details</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                
                <hr>
                <label>List of Available Amenities</label>
                <?php
                $sqlamenity = "SELECT description, price, services_number FROM services WHERE type='Amenities'";
                $resultamenity = $conn->query($sqlamenity);

                if ($resultamenity->num_rows > 0) 
                {

                    echo "<table class='table'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th style='width:5%;'>Select</th>";
                    echo "<th>Description</th>";
                    echo "<th>Price</th>";
                    echo "<th style='width:25%;'>Quantity</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($amenityRow  = $resultamenity->fetch_assoc()) 
                    {
                        echo "<tr>";
                        $totalAmenitiesPrice  = '';
                        if ($totalAmenitiesPrice != '') 
                        {
                            $amenitiesArray = explode(' | ', $Amenities_IDS);
                            $amenities_dict = [];

                            // Populate the array
                            foreach ($amenitiesArray as $amenity) {
                                preg_match('/(\w+) \[(\d+)\]/', $amenity, $matches);

                                if (count($matches) == 3) {
                                    $amenity_name = $matches[1];
                                    $quantity = (int)$matches[2];
                                    $amenities_dict[$amenity_name] = $quantity;
                                }
                            }

                            // Check if the description exists in the array
                            $isSelected = in_array($amenityRow['description'], array_keys($amenities_dict));

                            // Checkbox
                            echo "<td><input type='checkbox' name='selected_services[]' value='{$amenityRow['services_number']}'";
                            echo $isSelected ? ' checked' : '';
                            echo "></td>";

                            echo "<td>{$amenityRow['description']}</td>";
                            echo "<td>" . number_format($amenityRow['price'], 2) . " Php</td>";

                            // Input quantity with buttons
                            echo "<td>";
                            echo "<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-success' onclick='incrementQuantity(this, {$amenityRow['services_number']})'>+</button>&nbsp;";
                            echo "<input style='border-radius:1vh; width: 40px; text-align: center;' type='number' name='quantity[{$amenityRow['services_number']}]' value='" . ($isSelected ? $amenities_dict[$amenityRow['description']] : 0) . "' min='0' class='quantity-input'>";
                            echo "&nbsp;<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-danger' onclick='decrementQuantity(this, {$amenityRow['services_number']})'>-</button>";
                            echo "</td>";
                        } 
                        else 
                        {
                            echo "<td>{$amenityRow['description']}</td>";
                            echo "<td>" . number_format($amenityRow['price'], 2) . " Php</td>";

                            // If no amenities selected, just display checkboxes and default quantity input
                            echo "<td><input type='checkbox' name='selected_services[]' value='{$amenityRow['services_number']}'></td>";
                            echo "<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-success' onclick='incrementQuantity(this, {$amenityRow['services_number']})'>+</button>&nbsp;";
                            echo "<td><input style='border-radius:1vh; width: 40px; text-align: center;' type='number' name='quantity[{$amenityRow['services_number']}]' value='0' min='0' class='quantity-input'></td>";
                            echo "<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-danger' onclick='decrementQuantity(this, {$amenityRow['services_number']})'>-</button>";
                        }

                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";

                    // Add a submit button to save selected services in the session
                    echo "<center><button style='width:40%;' type='submit' name='save_selected_services' class='btn btn-primary'>Add Selected Amenities</button></center>";

                    echo "</form>";
                } 
                else 
                {
                    echo "No amenities found.";
                }
                ?>


            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.2.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>