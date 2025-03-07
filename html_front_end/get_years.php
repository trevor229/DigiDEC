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
    $result = $dbase->query('SELECT DISTINCT YEAR(TIMESTP) as year FROM alerts ORDER BY year DESC');
    $years = $result->fetchAll(PDO::FETCH_ASSOC);
}


?>

<?php foreach ($years as $year) { 
    $yrs = htmlspecialchars($year['year'], ENT_QUOTES);
?>
<option value="<?php echo $yrs; ?>" dbref="<?php echo $_GET["db"]; ?>"><?php echo $yrs; ?></option>
<?php } ?>