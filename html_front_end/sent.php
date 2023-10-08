<!-- PHP code to establish connection with the localserver -->
<?php
 
// Be smart and not hardcode creds dumdum
    $db_params = parse_ini_file( dirname(__FILE__).'/tx_db_creds.ini', false );
    $con=new mysqli($db_params['host'], $db_params['user'], $db_params['password'], $db_params['dbname'], $db_params['port'], $db_params['socket']);
    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $result = mysqli_query($con,"SELECT * FROM alerts ORDER BY TIMESTP DESC");
?>
<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <title>DigiDEC Sent Alerts</title>
    <!-- CSS FOR STYLING THE PAGE -->
    <style>
        <?php include "./page.css" ?>
    </style>
</head>
 
<body onload="set_cell_colors()">
    <div class="box">
                <div class="header">
                    <h1 class="title" style="padding-bottom: 5px;">DigiDEC Logs</h1>
                </div>
                <div class="navbar" style="padding-bottom: 10px;">
                    <ul>
                        <li><a href="/recieved.php">Received Alerts</a></li>
                        <li><a class="active"  href="/sent.php">Sent Alerts</a></li>
                        <li><a href="#kek">Alert Statistics</a></li>
                        <li><a href="/about.php">About</a></li>
                      </ul>
                </div>
                <div class="alert_table" id="alert_table"> 
                    <table>
                        <tr>
                            <th><P class="tabletext">Timestamp</P></th>
                            <th><P class="tabletext">Event</P></th>
                            <th><P class="tabletext">Description</P></th>
                            <th><P class="tabletext">ZCZC</P></th>
                        </tr>
                        <!-- PHP CODE TO FETCH DATA FROM ROWS -->
                        <?php
                            // LOOP TILL END OF DATA
                            while($rows = mysqli_fetch_array($result))
                            {
                        ?>
                        <tr>
                            <!-- FETCHING DATA FROM EACH ROW OF EVERY COLUMN -->
                            <td><P class="tabletext" id="timestamp"><?php echo $rows['TIMESTP'];?></P></td>
                            <td><P class="tabletext" id="event_text"><?php echo $rows['EVENT_TXT'];?></P></td>
                            <td><P class="tabletext" id="description"><?php echo $rows['DESCR'];?></P></td>
                            <td><P class="tabletext"id="zczc_text"><?php echo $rows['ZCZC_STR'];?></P></td>
                            <td style="display:none;"><P class="tabletext" id="alert_type"><?php echo $rows['TYPE'];?></P></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
            </div>
            <script>
                function set_cell_colors(){
                    var table = document.getElementById('alert_table');
                    var tbody = table.getElementsByTagName('tbody')[0];
                    var cells = tbody.getElementsByTagName('td');

                    for (var i=0, len=cells.length; i<len; i++){
                        if (cells[i].innerText == "test"){
                            cells[i-3].id = 'test';
                        }
                        else if (cells[i].innerText == "advisory"){
                            cells[i-3].id = 'advisory';
                        }
                        else if (cells[i].innerText == "watch"){
                            cells[i-3].id = 'watch';
                        }
                        else if (cells[i].innerText == "warning"){
                            cells[i-3].id = 'warning';
                        }
                    }
                }
            </script>
    </body>
</html>
