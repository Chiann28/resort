<?php
session_start();

// Check if the user is logged in as an admin (You may implement your own authentication logic)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html"); // Redirect to the login page if not logged in as admin
    exit();
}

require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Initialize variables
$promoCode = "";
$promoDiscount = "";
$editMode = false;
$promoId = 0;

// Handle Add Promo Code
if (isset($_POST['add_promo'])) {
    $promoCode = $_POST['promo_code'];
    $promoDiscount = $_POST['promo_discount'];

    // Validate input (You can add more validation as needed)
    if (!empty($promoCode) && is_numeric($promoDiscount)) {
        // Insert the new promo code into the database
        $insertQuery = "INSERT INTO promocode (promo_code, promo_discount) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("si", $promoCode, $promoDiscount);
        if ($stmt->execute()) {
            // Redirect or display a success message
            header("Location: manage_promocode.php");
            exit();
        } else {
            // Handle the case where the insertion fails
            $error = "Error adding promo code.";
        }
    } else {
        // Handle invalid input
        $error = "Invalid input. Please check the promo code and discount.";
    }
}

// Handle Edit Promo Code
if (isset($_POST['edit_promo'])) {
    $promoId = $_POST['promo_id'];
    $promoCode = $_POST['promo_code'];
    $promoDiscount = $_POST['promo_discount'];

    // Validate input (You can add more validation as needed)
    if (!empty($promoCode) && is_numeric($promoDiscount)) {
        // Update the promo code in the database
        $updateQuery = "UPDATE promocode SET promo_code = ?, promo_discount = ? WHERE promo_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sii", $promoCode, $promoDiscount, $promoId);
        if ($stmt->execute()) {
            // Redirect or display a success message
            header("Location: manage_promocode.php");
            exit();
        } else {
            // Handle the case where the update fails
            $error = "Error updating promo code.";
        }
    } else {
        // Handle invalid input
        $error = "Invalid input. Please check the promo code and discount.";
    }
}

// Handle Delete Promo Code
if (isset($_GET['delete_id'])) {
    $promoId = $_GET['delete_id'];

    // Delete the promo code from the database
    $deleteQuery = "DELETE FROM promocode WHERE promo_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $promoId);
    if ($stmt->execute()) {
        // Redirect or display a success message
        header("Location: manage_promocode.php");
        exit();
    } else {
        // Handle the case where the deletion fails
        $error = "Error deleting promo code.";
    }
}

// Fetch all promo codes from the database
$promoCodesQuery = "SELECT * FROM promocode";
$promoCodesResult = $conn->query($promoCodesQuery);

?>

<!-- HTML for displaying the promo codes and the form for adding/editing -->
<!DOCTYPE html>
<html>
<head>
<style>
        /* Overall page styles */
        body {
            font-family: Arial, sans-serif;
        }
        

        
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        
        /* Form styles */
        form {
            text-align: center;
            margin: 20px auto;
            width: 300px;
        }
        
        label {
            display: block;
            margin-top: 10px;
        }
        
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }
        
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            margin-top: 10px;
            cursor: pointer;
        }
        
        /* Table styles */
        table {
            border-collapse: collapse;
            margin: 20px auto;
        }
        
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        

    </style>
        <!-- local css -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
                     <a href="room_list.php" class="active">
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
            
            <<div class="header-menu">
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
            <h1>Promo codes</h1>
            <small>Home / Promo Codes</small>
        </div>
    

    <!-- Display success/error messages if needed -->
    <?php if (isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <!-- Form for adding/editing promo codes -->
    <form method="post">
        <input type="hidden" name="promo_id" value="<?php echo $promoId; ?>">
        <label for="promo_code">Promo Code:</label>
        <input type="text" name="promo_code" value="<?php echo $promoCode; ?>" required>
        <label for="promo_discount">Discount (%):</label>
        <input type="number" name="promo_discount" value="<?php echo $promoDiscount; ?>" required>
        <?php if ($editMode) { ?>
            <button type="submit" name="edit_promo">Edit Promo Code</button>
        <?php } else { ?>
            <button type="submit" name="add_promo" style="margin-top: 10px;">Add Promo Code</button>
        <?php } ?>
    </form>

    <!-- List of existing promo codes with edit and delete links -->
    <table>
        <thead>
            <tr>
                <th>Promo Code</th>
                <th>Discount (%)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $promoCodesResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['promo_code']; ?></td>
                    <td><?php echo $row['promo_discount']; ?></td>
                    <td>
                        <!-- <a href="manage_promocode.php?edit_id=<?php echo $row['promo_id']; ?>">Edit</a> -->
                        <a href="manage_promocode.php?delete_id=<?php echo $row['promo_id']; ?>" onclick="return confirm('Are you sure you want to delete this promo code?')"><i class="bi bi-trash3-fill"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    
      <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
</body>
</html>
