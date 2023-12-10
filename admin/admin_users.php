<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Users</title>
      <!-- local css -->
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <!-- Include your CSS and other dependencies here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php


session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}

require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user deletion
if (isset($_POST['delete_user_id'])) {
    $delete_user_id = $_POST['delete_user_id'];
    $delete_sql = "DELETE FROM users WHERE user_id = $delete_user_id";
    if ($conn->query($delete_sql) === true) {
        header("Location: admin_users.php"); // Redirect after successful deletion
        exit();
    } else {
        echo "<script>alert('Error: There are active reservations for this user. Cannot delete user.');</script>";
        // echo "Error deleting user: " . $conn->error;
    }
}

// Fetch all user data from the database
$sql = "SELECT * FROM users";
if (isset($_POST['search_username']) && !empty($_POST['search_username'])) {
    $search_username = $_POST['search_username'];
    $sql .= " WHERE username LIKE '%$search_username%'";
}
$result = $conn->query($sql);
?>
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
                     <a href="admin_users.php" class="active">
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
                    <a href=https://premium121.web-hosting.com:2096/cpsess6146287962/3rdparty/roundcube/index.php?_task=mail&_mbox=INBOX">
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
            <h1 style="margin-right: 10px;">Users</h1>
                <small>Home / User List</small>

            <form method="POST" class="mb-3" action="admin_users.php" style="margin-left: auto;">
                    <div class="input-group">
                        <input type="text" name="search_username" class="form-control" placeholder="Search by Username" style="width: 200px; height: 40px; margin-right: 10px;">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='admin_users.php'">Show All</button>
                        </div>
                    </div>
                </form>
            </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th> <!-- Delete column -->
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        // Delete button
                        echo "<td>";
                        echo "<form method='post' action='admin_users.php'>";
                        echo "<input type='hidden' name='delete_user_id' value='" . $row['user_id'] . "'>";
                        echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</main>
</div>
</body>
</html>
