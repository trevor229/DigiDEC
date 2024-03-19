<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <title>DigiDEC Recieved Alerts</title>
    <style>
        <?php include "./digidec.css" ?>
    </style>
</head>
<body>
<div class="box">
    <div class="header">
        <h1 class="title" style="padding-bottom: 5px;">DigiDEC Logs</h1>
    </div>
    <div class="navbar" style="padding-bottom: 10px;">
        <ul>
            <li><a href="/recieved.php">Received Alerts</a></li>
            <li><a href="/sent.php">Sent Alerts</a></li>
            <li><a class="active" href="/statistics.php">Alert Statistics</a></li>
            <li><a href="/about.php">About</a></li>
        </ul>
    </div>
    <div class="statistics">
        <div class="overallstats" id="overallStatistics">
        </div>
        <div class="monchans" id="monitorStatistics">
        </div>
        <div class="moststats" id="moststats">
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('overallStatistics').innerHTML = response.overall;
                    document.getElementById('monitorStatistics').innerHTML = response.monitor;
                    document.getElementById('moststats').innerHTML = response.most_active;
                } else {
                    console.error('Failed to load statistics:', xhr.statusText);
                }
            }
        };
        xhr.open('GET', 'display_statistics.php?database=digidec_rx_log', true);
        xhr.send();
    });
</script>
</body>
</html>
