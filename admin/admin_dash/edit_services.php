<?php
// Assuming you have established a database connection
require_once 'config.php';

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


// Check if the room ID is provided in the URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['services_number'])) {
    $services_number = $_GET['services_number'];

    // Fetch the room details from the database using the room ID
    $sql = "SELECT * FROM services WHERE services_number = '$services_number'";
    $result = $conn->query($sql);

    // Check if the room exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // You can use the retrieved room details to pre-fill the form for editing

        // Handle the form submission to update the room details
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // Assuming you have the necessary form fields for updating room details
    //         $new_room_number = $_POST['room_number'];
    //         $new_description = $_POST['description'];
    //         $new_price = $_POST['price'];
    //         // Add other form fields here
    //         $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    //         // Perform the update query to update the room details
    //         $update_sql = "UPDATE rooms 
    //                        SET room_number = '$new_room_number', 
    //                            description = '$new_description', 
    //                            price = '$new_price'
    //                            -- Add other columns and their new values here
    //                        WHERE room_id = '$room_id'";

    //         echo  $update_sql;
    //         if ($conn->query($update_sql) === TRUE) {
    //             // Room details updated successfully, redirect back to admin dashboard
    //             // header("Location: room_list.php");
    //             $conn->close();
    //             // exit();
    //         } else {
    //             // Error handling for the query
    //             // You can log the error for debugging purposes or display an error message to the admin
    //             echo "Error updating room details: " . $conn->error;
    //             // Alternatively, you can redirect the admin to an error page
    //             // header("Location: error_page.php?message=" . urlencode("Error updating room details"));
    //             // $conn->close();
    //             // exit();
    //         }
    //     }
    // } else {
        // Room not found, handle the error (e.g., redirect to an error page)
        // echo "Room not found.";
        // $conn->close();
        // exit();
    }
} else {
    // Room ID not provided in the URL, handle the error (e.g., redirect to an error page)
    echo "Invalid request.";
    $conn->close();
    exit();
}
?>

<style>
  /* Your CSS for the iframe content here */
  body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 20px;
  }

  h2 {
    color: #333;
    margin-bottom: 20px;
  }

  label {
    display: block;
    margin-bottom: 10px;
  }

  input[type="text"],
  textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;
  }
  input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;
  }

  button[type="submit"],
  button[type="button"] {
    background-color: #00cc00;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  }

  button[type="submit"] {
    margin-right: 10px;
  }

  button[type="button"] {
    background-color: #ccc;
  }

  .error-message {
    color: red;
    margin-bottom: 10px;
  }
</style>

<!-- Form fields for editing data -->
<h2>Edit Data</h2>
<form action="edit_services_handler.php" method="post">

<label for="email" style="display: none">Services ID:</label>
<input type="text" id="services_number" class="form-control" name="services_number" value="<?php echo $row['services_number']; ?>" required style="display: none"><br>

<label for="email">Description:</label>
<input type="text" id="description" class="form-control" name="description" value="<?php echo $row['description']; ?>" required><br>

<label for="email">Price:</label>
<input type="number" id="price" class="form-control" name="price" value="<?php echo $row['price']; ?>" required><br>


    <label for="type">Select Type</label>
    <select style='
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;' id="type" name="type" id="type" class="form-control"  required>

    <option value="Service" <?php echo ($row['type'] === 'Service') ? 'selected' : ''; ?>>Service</option>
    <option value="Amenities" <?php echo ($row['type'] === 'Amenities') ? 'selected' : ''; ?>>Amenities</option>
    </select>


<button type="submit">Save Changes</button>
</form>
