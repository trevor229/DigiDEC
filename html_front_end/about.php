<!DOCTYPE html>
<html lang="en">
 
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="favicon.jpg">
        <title>About DigiDEC</title>
        <!-- CSS FOR STYLING THE PAGE -->
        <style>
            <?php include "./page.css" ?>
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
                            <li><a href="#kek">Alert Statistics</a></li>
                            <li><a class="active" href="#lmao">About</a></li>
                        </ul>
                    </div>
                <div class="about">
                    <img src="digidec_logo_vector.png"></img>
                    <h1>DigiDEC version 0.1 by trevor229</h1>
                    <h3>DigiDEC is software written in Python to enable SAGE EAS ENDEC users with a Lantronix or similar serial server device to log their sent and recieved emergency alerts to a web front end and SQL database</h3>
                </div>
        </div>
    </body>
</html>