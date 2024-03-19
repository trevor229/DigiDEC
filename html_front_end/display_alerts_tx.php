<?php
// Connect to MySQL database
$db_params = parse_ini_file( dirname(__FILE__).'/db_creds.ini', false );
$conn=mysqli_connect($db_params['host'], $db_params['user'], $db_params['password'], $db_params['txdbname'], $db_params['port'], $db_params['socket']);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentYear = date('Y');
$sql = "SELECT * FROM alerts WHERE YEAR(TIMESTP) = $currentYear ORDER BY TIMESTP DESC";

// Check if year and event_code filters are set
if (isset($_GET['year']) && isset($_GET['event_code'])) {
    // Sanitize user input to prevent SQL injection
    $year = $conn->real_escape_string($_GET['year']);
    $event_code = $conn->real_escape_string($_GET['event_code']);

    // Modify SQL query to filter by year and event_code
    if (!empty($year) && !empty($event_code)) {
        $sql = "SELECT * FROM alerts WHERE YEAR(TIMESTP) = $year AND EVENT_CODE = '$event_code' ORDER BY TIMESTP DESC";
    } elseif (!empty($year)) {
        $sql = "SELECT * FROM alerts WHERE YEAR(TIMESTP) = $year ORDER BY TIMESTP DESC";
    } elseif (!empty($event_code)) {
        $sql = "SELECT * FROM alerts WHERE EVENT_CODE = '$event_code' ORDER BY TIMESTP DESC";
    } elseif (empty($year) && empty($event_code)) {
		$sql = "SELECT * FROM alerts ORDER BY TIMESTP DESC";
	}
}
elseif (isset($_GET['year'])) {
    // Sanitize user input to prevent SQL injection
    $year = $conn->real_escape_string($_GET['year']);

    // Modify SQL query to filter by year
    if (!empty($year)) {
        $sql = "SELECT * FROM alerts WHERE YEAR(TIMESTP) = $year ORDER BY TIMESTP DESC";
    }
}
elseif (isset($_GET['event_code'])) {
    // Sanitize user input to prevent SQL injection
    $event_code = $conn->real_escape_string($_GET['event_code']);

    // Modify SQL query to filter by event_code
    if (!empty($event_code)) {
        $sql = "SELECT * FROM alerts WHERE EVENT_CODE = '$event_code' ORDER BY TIMESTP DESC";
    }
}

// Execute SQL query
$result = $conn->query($sql);

// Display data
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
		echo "<td><P class=\"tabletext\" id=\"timestamp\">" . $row['TIMESTP'] . "</td>";
		echo "<td><P class=\"tabletext\" id=\"event_text\">" . $row['EVENT_TXT'] . "</td>";
        echo "<td><P class=\"tabletext\" id=\"description\">" . $row['DESCR'] . "</td>";  
        echo "<td><P class=\"tabletext\" id=\"zczc_text\">" . $row['ZCZC_STR'] . "</td>";
		echo "<td style=\"display:none;\">" . $row['TYPE'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>0 results found</td></tr>";
}

// Close database connection
$conn->close();
?>