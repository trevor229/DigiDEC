<?php
// Connect to database
require "dbconnection.php";
$dbase = '';

if ($_GET["db"] == "rx"){
    $dbase = connect_to_db("digidec_rx_log");
} elseif ($_GET["db"] == "tx") {
    $dbase = connect_to_db("digidec_tx_log");
} else {
    //throw new Exception("Invalid DB specified");
    echo 'Invalid DB "' . $_GET['db'] . '" specified';
} 

// Check if valid DB is specified, otherwise dont run any query
if ($dbase) {
    $result = $dbase->query('SELECT DISTINCT MON as monnum FROM alerts ORDER BY monnum ASC');
    $mons = $result->fetchAll(PDO::FETCH_ASSOC);
}


?>

<?php foreach ($mons as $mon) { 
    $monitor = htmlspecialchars($mon['monnum'], ENT_QUOTES);
?>
<option value="<?php echo $monitor; ?>" dbref="<?php echo $_GET["db"]; ?>"><?php echo $monitor; ?></option>
<?php } ?>