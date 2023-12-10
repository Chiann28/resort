<?php
// Assuming you have established a database connection

require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Calculate weekly sales data and label the weeks
$sql = "SELECT WEEK(reservations.check_in_date) AS week_number,
               DATE_FORMAT(MIN(reservations.check_in_date), '%Y-%m-%d') AS start_date,
               DATE_FORMAT(MAX(reservations.check_out_date), '%Y-%m-%d') AS end_date,
               SUM(rooms.price) AS weekly_sales
        FROM rooms
        INNER JOIN reservations ON rooms.room_id = reservations.room_id
        WHERE reservations.status = 'Approved'
        GROUP BY week_number
        ORDER BY week_number DESC";

$result = $conn->query($sql);

$data = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
