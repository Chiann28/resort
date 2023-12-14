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
  <style>
    /* Form container */
      .form-container {
        max-width: 400px;
        margin: 50px auto;
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

      /* Form elements */
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

      /* Error message */
      .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
      }

      /* Success message */
      .success-message {
        color: green;
        font-size: 14px;
        margin-top: 5px;
      }
      .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 9999; /* Ensure the popup overlaps other content */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            overflow-y: auto;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 60%; 
            max-height: 90%; 
            background-color: white;
            overflow-y: auto;
        }

        .modal-content-qr {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 80%; 
            max-height: 90%; 
            background-color: #fff;
            border: 2px solid #00cc00; 
            border-radius: 10px; 
            padding: 20px;
        }

        .modal-content-reserve {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 60%; 
            max-height: 90%; 
            background-color: #fff;
            border: 2px solid #00cc00; 
            border-radius: 10px; 
            padding: 20px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }
        .title{
            padding-top: 200px;
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
                     <a href="">
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
        <div class="page-header">
            <h1>Add new reservation</h1>
            <small>Home / Add new Reservation</small>
        </div>

        <div class="form-container">
    <h2>Check for Available Room</h2>
    <form id="roomSearchForm">
    <div class="form-group">
      <label for="check_in_date">Check-in Date:</label>
      <input type="date" id="check_in_date" name="check_in_date" onchange="updateCheckOutMin()" required>
    </div>

    <div class="form-group">
      <label for="check_out_date">Check-out Date:</label>
      <input type="date" id="check_out_date" name="check_out_date" required>
    </div>

        <div class="form-group">
            <button type="button" onclick="submitForm()">Search Available Rooms</button>
        </div>
    </form>
</div>

  

   <!-- The pop-up container -->
  <div id="availableRoomsPopup" class="modal">
      <div class="modal-content" style='border-radius:2vh;'>
          <span class="close" onclick="closeAvailableRoomsPopup()">&times;</span>
          <h2>Available Rooms:</h2>
          <div id="availableRoomsContent">
              <!-- The content of the available rooms will be loaded here using AJAX -->
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
  <script>

    const urlParams = new URLSearchParams(window.location.search)
    const showQRCode = urlParams.get('showQRCode');
    const room_id = urlParams.get('room_id');
    const check_in_date = urlParams.get('check_in_date');
    const check_out_date = urlParams.get('check_out_date');
    const reserve = urlParams.get('reserved')

    const room_idInput = document.querySelector('input[name="room_id_reserve"]');
    const check_in_dateInput = document.querySelector('input[name="check_in_date_reserve"]');
    const check_out_dateInput = document.querySelector('input[name="check_out_date_reserve"]');

    room_idInput.value = room_id;
    check_in_dateInput.value = check_in_date;
    check_out_dateInput.value = check_out_date;

    if (showQRCode === 'true') {
            const qrCodeSection = document.getElementById('qrSection');
            qrCodeSection.style.display = 'block';
    }

    if(reserve === 'true'){
      const reservedSuccess = document.getElementById('reservedSucess');
      reservedSuccess.style.dispay = 'block' 

    }

    function submitForm() {
        // Get form element by ID
        var form = document.getElementById("roomSearchForm");

        // Check if the form is valid (required fields are filled)
        if (form.checkValidity()) {
            // Call your custom function or perform any other actions
            showAvailableRooms();
        } else {
            // If the form is not valid, you can provide feedback to the user
            alert("Please fill in all required fields.");
        }
    }


      // Function to show the available rooms pop-up
    function showAvailableRooms() {

        var check_in_date = document.getElementById("check_in_date").value;
        var check_out_date = document.getElementById("check_out_date").value;


        // Get the availableRoomsPopup element
        var availableRoomsPopup = document.getElementById("availableRoomsPopup");

        // Show the availableRoomsPopup
        availableRoomsPopup.style.display = "block";

        // Load the available rooms content using AJAX
        var availableRoomsContent = document.getElementById("availableRoomsContent");
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              availableRoomsContent.innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "available_rooms_admin.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var params = "check_in_date=" + check_in_date + "&check_out_date=" + check_out_date;
        xhttp.send(params);
    }

    // Function to close the available rooms pop-up
    function closeAvailableRoomsPopup() {
        var availableRoomsPopup = document.getElementById("availableRoomsPopup");
        availableRoomsPopup.style.display = "none";
    }

    function closeQrPopup() {
        var qrSection = document.getElementById("qrSection");
        qrSection.style.display = "none";
    }

    function closeReservePopup() {
        var reservesucess = document.getElementById("reservedSucess");
        reservesucess.style.display = "none";
    }

    

</script>

<script>
    // Get the current date in the format "YYYY-MM-DD"
    function getCurrentDate() {
        const today = new Date();
        const year = today.getFullYear();
        let month = today.getMonth() + 1;
        let day = today.getDate();

        // Add leading zero if needed
        month = month < 10 ? `0${month}` : month;
        day = day < 10 ? `0${day}` : day;

        return `${year}-${month}-${day}`;
    }

    // Set the min attribute of the date input to the current date
    document.getElementById('check_in_date').min = getCurrentDate();
    document.getElementById('check_out_date').min = getCurrentDate();

    // Function to update the min attribute of the check-out date based on the check-in date
    function updateCheckOutMin() {
        const checkInDate = document.getElementById('check_in_date').value;
        document.getElementById('check_out_date').min = checkInDate;
    }
</script>


<script>
    // Function to get the next day's date in the format "YYYY-MM-DD"
    function getNextDay(dateString) {
        const currentDate = new Date(dateString);
        currentDate.setDate(currentDate.getDate() + 1);

        const year = currentDate.getFullYear();
        let month = currentDate.getMonth() + 1;
        let day = currentDate.getDate();

        // Add leading zero if needed
        month = month < 10 ? `0${month}` : month;
        day = day < 10 ? `0${day}` : day;

        return `${year}-${month}-${day}`;
    }

    // Function to update the min attribute of the check-out date based on the check-in date
    function updateCheckOutMin() {
        const checkInDate = document.getElementById('check_in_date').value;
        const checkOutDateInput = document.getElementById('check_out_date');

        // Ensure check-out date is always at least one day after check-in date
        checkOutDateInput.min = getNextDay(checkInDate);

        // If the check-out date is the same as the check-in date, show an alert
        if (checkOutDateInput.value === checkInDate) {
            alert('Cannot check in and check out on the same date.');
            // You can also reset the check-out date to the next day
            checkOutDateInput.value = getNextDay(checkInDate);
        }
    }
</script>
</body>
</html>