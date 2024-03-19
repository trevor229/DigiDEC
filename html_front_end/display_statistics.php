<?php
// Get selected database from the form
$selectedDatabase = $_GET['database'];
$dbname = $selectedDatabase;
// Connect to MySQL database
$db_params = parse_ini_file( dirname(__FILE__).'/db_creds.ini', false );
$conn=mysqli_connect($db_params['host'], $db_params['user'], $db_params['password'], $dbname, $db_params['port']);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// First query: Overall database statistics
$overall_query = "SELECT 
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'Warning') AS warning_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'Watch') AS watch_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'Advisory') AS advisory_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'Test') AS test_count,
                    (SELECT DATE(TIMESTP) FROM alerts GROUP BY DATE(TIMESTP) ORDER BY COUNT(*) DESC LIMIT 1) AS most_active_date,
                    (SELECT MON FROM alerts GROUP BY MON ORDER BY COUNT(*) DESC LIMIT 1) AS most_active_channel";

$result_overall = $conn->query($overall_query);

// Second query: Statistics for each monitor channel
$monitor_query = "SELECT 
                    MON AS monitor_channel,
                    COUNT(CASE WHEN TYPE = 'Warning' THEN 1 END) AS warning_count,
                    COUNT(CASE WHEN TYPE = 'Watch' THEN 1 END) AS watch_count,
                    COUNT(CASE WHEN TYPE = 'Advisory' THEN 1 END) AS advisory_count,
                    COUNT(CASE WHEN TYPE = 'Test' THEN 1 END) AS test_count
                FROM alerts
                GROUP BY MON";

$result_monitor = $conn->query($monitor_query);

// Third query: Most active day and most active channel
$most_active_query = "SELECT 
                        DATE(TIMESTP) AS most_active_date,
                        MON AS most_active_channel
                    FROM alerts
                    GROUP BY DATE(TIMESTP), MON
                    ORDER BY COUNT(*) DESC
                    LIMIT 1";

$result_most_active = $conn->query($most_active_query);

// Output data for overall database statistics
$overallStatistics = '';
if ($result_overall->num_rows > 0) {
    $row = $result_overall->fetch_assoc();
    $overallStatistics .= "<h1 class='statheader'>Total Alerts Received</h1>";
    $overallStatistics .= "<h2 class='warningheader'>Warnings: " . $row['warning_count'] . "</h2>";
    $overallStatistics .= "<h2 class='watchheader'>Watches: " . $row['watch_count'] . "</h2>";
    $overallStatistics .= "<h2 class='advisoryheader'>Advisories: " . $row['advisory_count'] . "</h2>";
    $overallStatistics .= "<h2 class='testheader'>Tests: " . $row['test_count'] . "</h2>";
    $overallStatistics .= "</div>";
}

// Output data for statistics for each monitor channel
$monitorStatistics = '';
if ($result_monitor->num_rows > 0) {
    while ($row = $result_monitor->fetch_assoc()) {
        $monitorStatistics .= "<div class='monchan' id='mon" . $row['monitor_channel'] . "'>";
        $monitorStatistics .= "<h1 class='statheader'>Mon " . $row['monitor_channel'] . "</h1>";
        $monitorStatistics .= "<h2 class='warningheader'>Warnings: " . $row['warning_count'] . "</h2>";
        $monitorStatistics .= "<h2 class='watchheader'>Watches: " . $row['watch_count'] . "</h2>";
        $monitorStatistics .= "<h2 class='advisoryheader'>Advisories: " . $row['advisory_count'] . "</h2>";
        $monitorStatistics .= "<h2 class='testheader'>Tests: " . $row['test_count'] . "</h2>";
        $monitorStatistics .= "</div>";
    }
}

// Output data for most active day and most active channel
$mostActiveStats = '';
if ($result_most_active->num_rows > 0) {
    $row_most_active = $result_most_active->fetch_assoc();
    $mostActiveStats .= "<h1 class='statheader'>Records</h1>";
    $mostActiveStats .= "<h2 class='mostsheader'>Most Active Day: " . $row_most_active['most_active_date'] . "</h2>";
    $mostActiveStats .= "<h2 class='mostsheader'>Most Active Alert Channel: " . $row_most_active['most_active_channel'] . "</h2>";
    $mostActiveStats .= "</div>";
}

// Close database connection
$conn->close();

// Output data as JSON
echo json_encode(array('overall' => $overallStatistics, 'monitor' => $monitorStatistics, 'most_active' => $mostActiveStats));
?>