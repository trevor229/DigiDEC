<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <title>DigiDEC Recieved Alerts</title>
	<style>
        <?php include "./digidec.css" ?>
    </style>
</head>
<body onload="set_cell_colors()">
    <div class="box">
                <div class="header">
                    <h1 class="title" style="padding-bottom: 5px;">DigiDEC Logs</h1>
                </div>
                <div class="navbar" style="padding-bottom: 10px;">
                    <ul>
                        <li><a class="active" href="/recieved.php">Received Alerts</a></li>
                        <li><a href="/sent.php">Sent Alerts</a></li>
                        <li><a href="/statistics.php">Alert Statistics</a></li>
                        <li><a href="/about.php">About</a></li>
                      </ul>
                </div>
		<form id="filterForm">
			<label for="year">Year:</label>
			<select name="year" id="year">
			<option value="">All</option>
				<?php
				// Generate options for years based on available data
				$currentYear = date('Y');
				for ($i = $currentYear; $i >= 2023; $i--) {
					$selected = ($i == $currentYear) ? "selected" : "";
					echo "<option value='$i' $selected>$i</option>";
				}
				?>
			</select>
			<label for="event_code">Event:</label>
			<select name="event_code" id="event_code">
				<option value="">All</option>
				<?php
				// Associative array mapping event codes to their names
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

				// Generate options for event codes
				foreach ($event_names as $code => $name) {
					echo "<option value='$code'>$name</option>";
				}
				?>
			</select>
			<input type="submit" class="filterbttn" value="Filter">
		</form>

		<!-- Display alerts table here -->
		<div class="alert_table" id="alert_table">
			<table border="1" id="alertsTable" style="width: -webkit-fill-available">
				<thead>
					<tr>
						<th><P class="tabletext">Timestamp</th>
						<th><P class="tabletext">Event</th>
						<th><P class="tabletext">Description</th>
						<th><P class="tabletext">Endec Filter</th>
						<th><P class="tabletext">Monitor Channel</th>
						<th><P class="tabletext">ZCZC</th>
					</tr>
				</thead>
				<tbody id="alertsBody">
					<!-- PHP will populate this section -->
					<?php include 'display_alerts_rx.php'; ?>
				</tbody>
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
						cells[i-5].id = 'test';
					}
					else if (cells[i].innerText == "advisory"){
						cells[i-5].id = 'advisory';
					}
					else if (cells[i].innerText == "watch"){
						cells[i-5].id = 'watch';
					}
					else if (cells[i].innerText == "warning"){
						cells[i-5].id = 'warning';
					}
				}
			}
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            
            var formData = new FormData(this); // Get form data
            var xhr = new XMLHttpRequest(); // Create new XMLHttpRequest object
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('alertsBody').innerHTML = xhr.responseText; // Replace table body content
					set_cell_colors();
                }
            };
            
            xhr.open('GET', 'display_alerts_rx.php?' + new URLSearchParams(formData).toString(), true); // Prepare GET request
            xhr.send(); // Send request
        });
    </script>
</body>
</html>
