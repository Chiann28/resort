<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database configuration
    require 'config.php';

    // Establish a database connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $name = $_POST['name'];
    $room_id = $_POST['room_id'];
    $arrival_date = $_POST['arrival_date'];
    $num_adults = $_POST['num_adults'];
    $num_children = $_POST['num_children'];
    $departure_date = $_POST['departure_date'];
    $child_age = $_POST['child_age'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Insert basic booking information into the database
    $sql = "INSERT INTO walkin (name, room_id, arrival_date, num_adults, num_children, departure_date, child_age, email, address)
            VALUES ('$name', '$room_id', '$arrival_date', '$num_adults', '$num_children', '$departure_date', '$child_age', '$email', '$address')";

    if ($conn->query($sql) === TRUE) {
        // Booking information inserted successfully, get the last inserted ID
        $booking_id = $conn->insert_id;

        // Insert selected amenities into the database
        if (isset($_POST['selected_services']) && is_array($_POST['selected_services'])) {
            foreach ($_POST['selected_services'] as $service_number) {
                $quantity = $_POST['quantity'][$service_number];
                $sqlAmenities = "INSERT INTO booking_amenities (booking_id, service_number, quantity)
                                VALUES ('$booking_id', '$service_number', '$quantity')";
                $conn->query($sqlAmenities);
            }
        }

        echo "Booking created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to the form page if accessed directly
    header("Location: add_new_reservations.php");
    exit();
}
?>
