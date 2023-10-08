<!-- PHP code to establish connection with the localserver -->
<?php
    
    include 'db_connection.php';
    
    // Define the value you want to count
    
    // Build the SQL query to count entries with the specified value
    function queryBuilder($txrx, $countValue) {
        $query = "SELECT COUNT(*) as count FROM $txrx WHERE TYPE = '$countValue'";

        // Execute the query
        $result = mysqli_query($conn, $query);
    
        // Check if the query executed successfully

        if ($result) {
             $row = mysqli_fetch_assoc($result);
             $count = $row['count'];
             echo $count;
        }
    }
    
    
    
?>
<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="favicon.jpg">
        <title>DigiDEC Recieved Alerts</title>
        <!-- CSS FOR STYLING THE PAGE -->
        <style>
            <?php include "./test.css" ?>
        </style>
    </head>
    <body onload="set_cell_colors()">
    <div class="box">
                <div class="header">
                    <h1 class="title" style="padding-bottom: 5px;">DigiDEC Logs</h1>
                </div>
                <div class="navbar" style="padding-bottom: 10px;">
                    <ul>
                        <li><a href="/recieved.php">Received Alerts</a></li>
                        <li><a href="/sent.php">Sent Alerts</a></li>
                        <li><a class="active" href="/statistics.php">Alert Statistics</a></li>
                        <li><a href="/about.php">About</a></li>
                      </ul>
                </div>
                <div class="stats">
                    <h1>Total Alerts Recieved: </h1>
                    <h2>Warnings: <?php queryBuilder("digidec_rx_log", "warning");?></h2>
                    <h2>Watches: </h2>
                    <h2>Advisories: </h2>
                    <h2>Tests: </h2>
                    <h1>Total Alerts Sent: </h1>
                    <h2>Warnings: </h2>
                    <h2>Watches: </h2>
                    <h2>Advisories: </h2>
                    <h2>Tests: </h2>
                </div>
    </body>
</html>