<?php
// Include necessary files and perform session validation

require_once 'config.php';


session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Fetch all inquiries from the database
$query = "SELECT * FROM inquiries";
$result = $conn->query($query);
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>
<?php
require 'admin_navbar.php';
?>
<div class="container" style="margin-top: 150px;">
    <h2>All Inquiries</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo ($row['status'] == 1) ? 'Viewed' : 'Not Viewed'; ?></td>
                    <td>
                        <button class="btn btn-primary" onclick="showInquiry(<?php echo $row['id']; ?>)">Show</button>
                        <button class="btn btn-danger" onclick="deleteInquiry(<?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal" id="inquiryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Inquiry Details</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
                <p><strong>Message:</strong></p> 
                <p id="modalMessage" style="white-space: pre-wrap; word-wrap: break-word;"></p>
                <!-- ... other details ... -->
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>

<script>
    function showInquiry(inquiryId) {
             // Fetch and display inquiry details in Bootstrap modal
             fetch('get_inquiry_details.php?id=' + inquiryId)
            .then(response => response.json())
            .then(data => {
                // Populate modal content with fetched data
                document.getElementById('modalSubject').textContent = data.subject;
                document.getElementById('modalMessage').textContent = data.message;
                // ... populate other modal content ...

            // Update the inquiry status to "Viewed" via AJAX
            fetch('update_inquiry_status.php?id=' + inquiryId, {
                    method: 'POST',
                    // body: JSON.stringify({ status: 1 }), // 1 represents "Viewed"
                    body: 'status=1',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);  // Log the response content
                    return JSON.parse(data);  // Parse the response as JSON
                })
                .then(data => {
                    if (data.success) {
                        // Update the status cell in the table
                        const statusCell = document.querySelector(`#status_${inquiryId}`);
                        statusCell.textContent = 'Viewed';
                    }
                });
                
                // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('inquiryModal'));
            modal.show();
        });
    }

    function deleteInquiry(inquiryId) {
        // Replace this with your logic to delete the inquiry
        // You can use AJAX to send a request to a PHP script that deletes the inquiry
    }
</script>

      <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  <!-- Include Bootstrap JS at the end of the body -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->


</body>
</html>
