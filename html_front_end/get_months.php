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
    $result = $dbase->query('SELECT DISTINCT MONTH(TIMESTP) as months FROM alerts ORDER BY months ASC');
    $months = $result->fetchAll(PDO::FETCH_ASSOC);
}

$month_names = array(
    "1" => "Jan",
    "2" => "Feb",
    "3" => "Mar",
    "4" => "Apr",
    "5" => "May",
    "6" => "Jun",
    "7" => "Jul",
    "8" => "Aug",
    "9" => "Sep",
    "10" => "Oct",
    "11" => "Nov",
    "12" => "Dec"
);

?>


<?php foreach ($months as $month) { 
    $mths = htmlspecialchars($month['months'], ENT_QUOTES);
    $fmonth = isset($month_names[$mths]) ? $month_names[$mths] : $mth;
?>
<option value="<?php echo $mths; ?>" dbref="<?php echo $_GET["db"]; ?>"><?php echo $fmonth; ?></option>
<?php } ?>