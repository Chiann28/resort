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

   <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Fetch total reservations from the PHP script
      fetch('getTotalReservations.php')
        .then(response => {
          // Check if the response is a successful HTTP response (status code 2xx)
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          // Update the total reservations on the page
          document.querySelector('.card h2').textContent = data.total_reservations;
        })
        .catch(error => console.error('Error fetching data:', error.message));
    });
  </script>
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
                     <a href="" class="active">
                          <span class="las la-home"></span>
                          <small>Dashboard</small>
                      </a>
                  </li>
                  <li>
                     <a href="room_list.php">
                          <span class="las la-boxes"></span>
                          <small>Room List</small>
                      </a>
                  </li>
                  <li>
                     <a href="services_list.php">
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
                     <a href="add_new_reservations.php">
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
        
        <div class="page-header">
            <h1>Dashboard</h1>
            <small>Home / Dashboard</small>
        </div>
        <div class="page-content">
            <div class="analytics">
                <div class="card">
                    <div class="card-head">
                        <?php
                            // Replace with your actual database credentials
                            require_once 'config.php';


                            // Create connection
                            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                              die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch total reservations from the database
                            $query = "SELECT COUNT(*) AS total_reservations FROM reservations";
                            $result = $conn->query($query);

                            if ($result) {
                              $row = $result->fetch_assoc();
                              $totalReservations = $row['total_reservations'];

                              // Output the total reservations as part of the HTML
                              echo '<h2>' . $totalReservations . '</h2>';

                              // Close the database connection
                              $conn->close();
                            } else {
                              // Handle the query error
                              echo '<h2>Error fetching total reservations</h2>';
                            }
                            ?>
                        <span class="las la-user-friends"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total reservations</small>
                        <div class="card-indicator">
                            <div class="indicator one" style="width: 60%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <?php

                            
                            require_once 'config.php';

                            // Create connection
                            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                              die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch total reservations from the database
                            $query = "SELECT COUNT(*) AS total_users FROM users";
                            $result = $conn->query($query);

                            if ($result) {
                              $row = $result->fetch_assoc();
                              $totalReservations = $row['total_users'];

                              // Output the total reservations as part of the HTML
                              echo '<h2>' . $totalReservations . '</h2>';

                              // Close the database connection
                              $conn->close();
                            } else {
                              // Handle the query error
                              echo '<h2>Error fetching total reservations</h2>';
                            }
                            ?>
                        <span class="las la-eye"></span>
                    </div>
                    <div class="card-progress">
                        <small>Number of users</small>
                        <div class="card-indicator">
                            <div class="indicator two" style="width: 80%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                            <?php
                                require 'config.php';
                                
                            // Create connection
                            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch total amount_paid from the reservations table
                            $query = "SELECT SUM(paid_amount) AS total_sales FROM reservations";
                            $result = $conn->query($query);

                            if ($result) {
                                $row = $result->fetch_assoc();
                                $totalSales = $row['total_sales'];

                                // Output the total sales as part of the HTML
                                echo '<h2>₱ ' . $totalSales . '</h2>';

                                // Close the database connection
                                $conn->close();
                            } else {
                                // Handle the query error
                                echo '<h2>Error fetching total sales</h2>';
                            }
                        ?>
                        <h2></h2>
                        <span class="las la-shopping-cart"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total sales</small>
                        <div class="card-indicator">
                            <div class="indicator three" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <?php

                        require 'config.php';

                            // Create connection
                            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                              die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch total reservations from the database
                            $query = "SELECT COUNT(*) AS total_inquiries FROM inquiries";
                            $result = $conn->query($query);

                            if ($result) {
                              $row = $result->fetch_assoc();
                              $totalReservations = $row['total_inquiries'];

                              // Output the total reservations as part of the HTML
                              echo '<h2>' . $totalReservations . '</h2>';

                              // Close the database connection
                              $conn->close();
                            } else {
                              // Handle the query error
                              echo '<h2>Error fetching total reservations</h2>';
                            }
                            ?>
                        <span class="las la-envelope"></span>
                    </div>
                    <div class="card-progress">
                        <small>New E-mails received</small>
                        <div class="card-indicator">
                            <div class="indicator four" style="width: 90%"></div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="records table-responsive">

                <div class="record-header">
                    <div class="add">
                        <span>Entries</span>
                        
                       
                    </div>

                    <div class="browse">
                       
                        
                    </div>
                </div>

                <div>


                <?php

                require 'config.php';

                // Create connection
                $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch all reservations from the reservations table
                $query = "SELECT r.reservation_id, u.name, u.email, r.check_in_date, r.check_out_date, r.paid_amount, r.status
                FROM reservations r
                INNER JOIN users u ON r.user_id = u.user_id";
                $result = $conn->query($query);

                if ($result) {
                    echo '<table width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><span class="las la-sort"></span> CUSTOMER NAME</th>
                                    <th><span class="las la-sort"></span> CHECK IN</th>
                                    <th><span class="las la-sort"></span> CHECK OUT</th>
                                    <th><span class="las la-sort"></span> AMOUNT</th>
                                    <th><span class="las la-sort"></span> STATUS</th>
                                </tr>
                            </thead>
                            <tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                                <td>' . $row['reservation_id'] . '</td>
                                <td>
                                    <div class="client">
                                        <div class="client-info">
                                            <h4>' . $row['name'] . '</h4>
                                            <small>' . $row['email'] . '</small>
                                        </div>
                                    </div>
                                </td>
                                <td>' . $row['check_in_date'] . '</td>
                                <td>' . $row['check_out_date'] . '</td>
                                <td>' . $row['paid_amount'] . '</td>
                                <td>' . $row['status'] . '</td>
                            </tr>';
                    }

                    echo '</tbody>
                        </table>';

                    // Close the database connection
                    $conn->close();
                } else {
                    // Handle the query error
                    echo '<p>Error fetching reservations</p>';
                }
                ?>  
                </div>

            </div>
        
        </div>
        
    </main>
    
</div>



    <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>s
  
  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
</body>
</html>