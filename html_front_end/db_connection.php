<?php
// Database credentials
$host = "";
$username = "";
$password = "";
$db_name = "";

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $db_name);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>