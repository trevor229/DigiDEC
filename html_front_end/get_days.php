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
    $result = $dbase->query('SELECT DISTINCT DAY(TIMESTP) as days FROM alerts ORDER BY days ASC');
    $days = $result->fetchAll(PDO::FETCH_ASSOC);
}


?>

<li><hr class="dropdown-divider"></li>
<option value="all" dbref="<?php echo $_GET["db"]; ?>">All</option>

<?php foreach ($days as $day) { 
    $dys = htmlspecialchars($day['days'], ENT_QUOTES);
?>
<option value="<?php echo $dys; ?>" dbref="<?php echo $_GET["db"]; ?>"><?php echo $dys; ?></option>
<?php } ?>