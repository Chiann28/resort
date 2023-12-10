<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>

</head>
<body>

<?php
require 'admin_navbar.php';
// ... Your PHP code here ...

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

$approvedRoomsQuery = "SELECT rooms.room_number, rooms.description, rooms.price, reservations.check_in_date, reservations.check_out_date
                      FROM rooms
                      INNER JOIN reservations ON rooms.room_id = reservations.room_id
                      WHERE reservations.status = 'Approved'";
$approvedRoomsResult = $conn->query($approvedRoomsQuery);

$totalSales = 0;

?>
<div class="container" style="margin-top:150px;">
 <!-- Add Buttons for Different Sales Reports -->
    <div class="btn-group">
        <button class="btn btn-primary" onclick="showWeeklySales()">Weekly Sales</button>
        <button class="btn btn-primary" onclick="showMonthlySales()">Monthly Sales</button>
        <button class="btn btn-primary" onclick="showOverallSales()">Overall Sales</button>
    </div>

    <!-- Display Approved Rooms and Calculate Total Sales -->
    <h2>Sales Report - Approved Rooms</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Room Number</th>
                <th>Description</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($approvedRoom = $approvedRoomsResult->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $approvedRoom['room_number']; ?></td>
                    <td><?php echo $approvedRoom['description']; ?></td>
                    <td><?php echo $approvedRoom['check_in_date']; ?></td>
                    <td><?php echo $approvedRoom['check_out_date']; ?></td>
                    <td><?php echo $approvedRoom['price']; ?></td>
                </tr>
                <?php
                    // Add room price to the total sales
                    $totalSales += $approvedRoom['price'];
                ?>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Display Total Sales -->
    <h4>Total Sales: <?php echo $totalSales; ?></h4>

    <div id="sales-type"></div>
    <div id="sales-data"></div>
</div>

<canvas id="weeklySalesChart" width="400" height="200"></canvas>
<canvas id="monthlySalesChart" width="400" height="200"></canvas>
<canvas id="overallSalesChart" width="400" height="200"></canvas>


<!-- Include Bootstrap JS at the end of the body -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let weeklySalesChart = null;
    let monthlySalesChart = null;
    let overallSalesChart = null;

    const weeklyCanvas = document.getElementById('weeklySalesChart');
    const monthlyCanvas = document.getElementById('monthlySalesChart');
    const overallCanvas = document.getElementById('overallSalesChart');

 
    function showWeeklySales() {

        weeklyCanvas.style.display = 'block';
        monthlyCanvas.style.display = 'none';
        overallCanvas.style.display = 'none';

        fetch('fetch_weekly_sales.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('sales-type').innerHTML = 'Weekly Sales';

                // Get the element where you want to display the sales data
                const salesDataElement = document.getElementById('sales-data');

                // Clear any previous content
                salesDataElement.innerHTML = '';

                // Set the display property to flex to create a horizontal layout
                salesDataElement.style.display = 'flex';
                salesDataElement.style.flexWrap = 'wrap';

                // Loop through the data and create HTML elements
                data.forEach(week => {
                    const weekCard = document.createElement('div');
                    weekCard.style.width = '200px';
                    weekCard.style.padding = '15px';
                    weekCard.style.border = '1px solid #ccc';
                    weekCard.style.borderRadius = '8px';
                    weekCard.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                    weekCard.style.textAlign = 'center';
                    weekCard.style.margin = '10px';
                    weekCard.style.flex = '0 0 calc(33.33% - 20px)'; // Adjust the percentage based on your layout

                    const weekLabel = document.createElement('div');
                    weekLabel.style.fontSize = '18px';
                    weekLabel.style.fontWeight = 'bold';
                    weekLabel.style.marginBottom = '10px';
                    weekLabel.textContent = 'Week ' + week.week_number;
                    weekCard.appendChild(weekLabel);

                    const salesAmount = document.createElement('div');
                    salesAmount.style.fontSize = '16px';
                    salesAmount.style.color = '#007bff';
                    salesAmount.textContent = 'Php ' + week.weekly_sales;
                    weekCard.appendChild(salesAmount);

                    salesDataElement.appendChild(weekCard);
                });
            // Update the canvas element where the chart will be displayed
            const canvas = document.getElementById('weeklySalesChart');

            // Create a dataset with the sales data
            const salesData = data.map(week => week.weekly_sales);

            // Create labels for the X-axis (e.g., week numbers)
            const weekLabels = data.map(week => 'Week ' + week.week_number);

            // Ensure the chart is created or updated
            if (weeklySalesChart) {
                weeklySalesChart.data.labels = weekLabels;
                weeklySalesChart.data.datasets[0].data = salesData;
                weeklySalesChart.update();
            } else {
                weeklySalesChart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: weekLabels,
                        datasets: [{
                            label: 'Weekly Sales',
                            data: salesData,
                            borderColor: 'blue',
                            fill: false,
                        }],
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true,
                            },
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
            }

            });


    }


    function showMonthlySales() {

        weeklyCanvas.style.display = 'none';
        monthlyCanvas.style.display = 'block';
        overallCanvas.style.display = 'none';


    fetch('fetch_monthly_sales.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('sales-type').innerHTML = 'Monthly Sales';

            // Get the element where you want to display the sales data
            const salesDataElement = document.getElementById('sales-data');

            // Clear any previous content
            salesDataElement.innerHTML = '';

            // Set the display property to flex to create a horizontal layout
            salesDataElement.style.display = 'flex';
            salesDataElement.style.flexWrap = 'wrap';

            // Loop through the data and create HTML elements
            data.forEach(month => {
                const monthCard = document.createElement('div');
                monthCard.style.width = '200px';
                monthCard.style.padding = '15px';
                monthCard.style.border = '1px solid #ccc';
                monthCard.style.borderRadius = '8px';
                monthCard.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                monthCard.style.textAlign = 'center';
                monthCard.style.margin = '10px';
                monthCard.style.flex = '0 0 calc(33.33% - 20px)'; // Adjust the percentage based on your layout

                const monthLabel = document.createElement('div');
                monthLabel.style.fontSize = '18px';
                monthLabel.style.fontWeight = 'bold';
                monthLabel.style.marginBottom = '10px';
                monthLabel.textContent = month.month;
                monthCard.appendChild(monthLabel);

                const salesAmount = document.createElement('div');
                salesAmount.style.fontSize = '16px';
                salesAmount.style.color = '#007bff';
                salesAmount.textContent = 'Php ' + month.monthly_sales;
                monthCard.appendChild(salesAmount);

                salesDataElement.appendChild(monthCard);
            });

            // Update the canvas element where the chart will be displayed
            const canvas = document.getElementById('monthlySalesChart');


            // Create a dataset with the sales data
            const salesData = data.map(month => month.monthly_sales);

            // Create labels for the X-axis (e.g., week numbers)
            const monthLabels = data.map(month => 'Month ' + month.month_number);

            // Ensure the chart is created or updated
            if (monthlySalesChart) {
                monthlySalesChart.data.labels = monthLabels;
                monthlySalesChart.data.datasets[0].data = salesData;
                monthlySalesChart.update();
            } else {
                monthlySalesChart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                            label: 'Monthly Sales',
                            data: salesData,
                            borderColor: 'blue',
                            fill: false,
                        }],
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true,
                            },
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
            }
        });
    }



    function showOverallSales() {

        
        weeklyCanvas.style.display = 'none';
        monthlyCanvas.style.display = 'none';
        overallCanvas.style.display = 'block';


    fetch('fetch_overall_sales.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('sales-type').innerHTML = 'Overall Sales';
            document.getElementById('sales-data').innerHTML = 'Php ' + data.overall_sales;

            // Get the canvas element for the chart
            const canvas = document.getElementById('overallSalesChart');

            // Extract the overall sales value from the response
            const overallSales = data.overall_sales;

            // Create a dataset with the sales data
            // const salesData = data.map(overall => data.overall_sales);

            // Create labels for the X-axis (e.g., week numbers)
            // const monthLabels = data.map(overall => 'Month ' + data.overall_sales);

            // Create the chart options
            const chartOptions = {
                scales: {
                    x: {
                        beginAtZero: true,
                    },
                    y: {
                        beginAtZero: true,
                    },
                },
            };


            if (overallSalesChart) {
                // overallSalesChart.data.labels = monthLabels;
                overallSalesChart.data.datasets[0].data = overallSales;
                overallSalesChart.update();
            } else {
                overallSalesChart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: 'Overall Sales',
                        datasets: [{
                            label: 'Overall Sales',
                            data: overallSales,
                            borderColor: 'blue',
                            fill: false,
                        }],
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true,
                            },
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
            }
            
        });
}

    
</script>


</body>
</html>