<?php
// Assuming you have established a database connection

require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch monthly sales data
$query = "SELECT DATE_FORMAT(check_in_date, '%Y-%m') AS month, SUM(price) AS monthly_sales
          FROM reservations
          INNER JOIN rooms ON reservations.room_id = rooms.room_id
          WHERE reservations.status = 'Approved'
          GROUP BY DATE_FORMAT(check_in_date, '%Y-%m')
          ORDER BY DATE_FORMAT(check_in_date, '%Y-%m')";

$result = $conn->query($query);

$monthlySalesData = array();

while ($row = $result->fetch_assoc()) {
    $monthlySalesData[] = array(
        "month" => $row["month"],
        "monthly_sales" => $row["monthly_sales"]
    );
}

echo json_encode($monthlySalesData);

$conn->close();
?>
