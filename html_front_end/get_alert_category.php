<?php

if ($_GET["db"] == "rx"){

} elseif ($_GET["db"] == "tx") {

} else {
    echo 'Invalid DB "' . $_GET['db'] . '" specified';
} 
// Check if valid DB is specified

?>
<option value="warning" dbref="<?php echo $_GET["db"]; ?>">Warning</option>
<option value="watch" dbref="<?php echo $_GET["db"]; ?>">Watch</option>
<option value="advisory" dbref="<?php echo $_GET["db"]; ?>">Advisory</option>
<option value="test" dbref="<?php echo $_GET["db"]; ?>">Test</option>