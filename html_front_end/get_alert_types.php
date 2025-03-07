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


// List of SAME alert codes

$event_names = array(
    "ADR" => "Administrative Message",
    "AVA" => "Avalanche Watch",
    "AVW" => "Avalanche Warning",
    "BZW" => "Blizzard Warning",
    "CAE" => "Child Abduction Emergency",
    "CDW" => "Civil Danger Warning",
    "CEM" => "Civil Emergency Message",
    "CFA" => "Coastal Flood Watch",
    "CFW" => "Coastal Flood Warning",
    "DMO" => "Practice/Demo Warning",
    "DSW" => "Dust Storm Warning",
    "EAN" => "Emergency Action Notification",
    "EAT" => "Emergency Action Termination",
    "EQW" => "Earthquake Warning",
    "EVI" => "Evacuation Immediate",
    "EWW" => "Extreme Wind Warning",
    "FFA" => "Flash Flood Watch",
    "FFS" => "Flash Flood Statement",
    "FFW" => "Flash Flood Warning",
    "FLA" => "Flood Watch",
    "FLS" => "Flood Statement",
    "FLW" => "Flood Warning",
    "FRW" => "Fire Warning",
    "FSW" => "Flash Freeze Warning",
    "FZW" => "Freeze Warning",
    "HLS" => "Hurricane Local Statement",
    "HMW" => "Hazardous Material Warning",
    "HUA" => "Hurricane Warning",
    "HUW" => "Hurricane Watch",
    "HWA" => "High Wind Watch",
    "HWW" => "High Wind Warning",
    "LAE" => "Local Area Emergency",
    "LEW" => "Law Enforcement Warning",
    "NAT" => "National Audible Test",
    "NIC" => "National Information Center",
    "NMN" => "Network Notification Message",
    "NPT" => "National Periodic Test",
    "NST" => "National Silent Test",
    "NUW" => "Nuclear Power Plant Warning",
    //"MEP" => "Missing Endangered Person",
    "RHW" => "Radiological Hazard Warning",
    "RMT" => "Required Monthly Test",
    "RWT" => "Requred Weekly Test",
    "SMW" => "Special Marine Warning",
    "SPS" => "Special Weather Statement",
    "SPW" => "Shelter In-Place Warning",
    "SQW" => "Snow Squall Warning",
    "SSA" => "Storm Surge Watch",
    "SSW" => "Storm Surge Warning",
    "SVA" => "Severe Thunderstorm Watch",
    "SVR" => "Severe Thunderstorm Warning",
    "SVS" => "Severe Weather Statement",
    "TOA" => "Tornado Watch",
    "TOR" => "Tornado Warning",
    "TRA" => "Tropical Storm Watch",
    "TRW" => "Tropical Storm Warning",
    "TSA" => "Tsunami Watch",
    "TSW" => "Tsunami Warning",
    "VOW" => "Volcano Warning",
    "WSA" => "Winter Storm Watch",
    "WSW" => "Winter Storm Warning"
);

// Check if valid DB is specified, otherwise dont run any query
if ($dbase) {
    $result = $dbase->query('SELECT DISTINCT EVENT_CODE as type FROM alerts ORDER BY type ASC');
    $alertTypes = $result->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php foreach ($alertTypes as $row) { 
    $code = htmlspecialchars($row['type'], ENT_QUOTES);
    $name = isset($event_names[$code]) ? $event_names[$code] : $code;
?>
<option value="<?php echo $code; ?>" dbref="<?php echo $_GET["db"]; ?>"><?php echo $name; ?></option>
<?php } ?>