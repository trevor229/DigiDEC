<?php
function connect_to_db($dbname) {
    $db_params = parse_ini_file(dirname(__FILE__).'/db_creds.ini', false );

    $host = $db_params['host'];
    $username = $db_params['user'];
    $password = $db_params['password'];

    try {
        // Connect to database
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}
?>