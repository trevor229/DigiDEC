![This is an image](/logos/digidec_logo_vector.png)
# DigiDEC - SAGE EAS Endec Serial/Telnet Logging Software with Discord Webhook integration

### DigiDEC is software written in Python to parse, log, and display emergency alerts recieved by the Sage EAS ENDEC model 1822 via local serial connection (WIP) or a remote serial server.

# Features

✔️ Telnet based serial server support

✔️ MySQL database logging

✔️ PHP based web front end pages to review alerts

✔️ Discord webhook integration

# What's needed to run
* apache2 
* php8.1
* php8.1-mysql
* python3
* python3-pip
    * mysql-connector-python
    * discord_webhook

`sudo apt-get install apache2 php8.1 php8.1-mysql python3 python3-pip`

`python3 -m pip install mysql-connector-python discord_webhook`

# Installation

* Install/ensure the dependencies listed above are on your target system (Ubuntu server is recommended)

# Configuration

## __Before anything, if you are using a Lantronix serial server, read this!__
By default, the UDS200 (And 2000 I believe) cache unread bytes recieved on the serial ports and output them when the telnet interface is accessed. We dont want this! It can cause duplicates. To turn this feature off (to the best of my knowledge), do the following:

* Telnet in on the configuration interface (usually port 9999)
* press 1 or 2 to select which channel/port your endec is on
* ensure your baudrate is matching the endec's
* keep pressing enter until you reach FlushMode and set the value to `11`, which in the manual corresponds (in binary) to turning off the caching feature
* once you are back at the main configuration screen, be sure to save your settings!

#

## Configuration parameters are found within the `settings.json` file
* `embed`

    * `alert_colors`
    Colors of the accent bar on the left hand side of Discord webhood messages, Leave them unless you want different shades of these.

        * `test_hex`
        Any "Test" alerts are the same as Advisories, but I defined the test alerts (RWT, RMT, NPT, etc) just in case you want to change their colors or log them differently. Stock bahavior is both test and advisory are green color on webhooks

* `webhook`

    * `url` - Your Discord webhook URL goes here

    * `zczc_str_enable` - Enable or disable putting the ZCZC EAS message string in the Discord embed

    * `enable_sent_alerts` - Enable or disable webhook messages of alerts originated from the endec itself (ie, sent from the control panel)

    * `enable_rx_alerts` - Enable or disable webhook messages of alerts recieved via monitor ports on your endec. This is kinda the main feature so I'd leave this on...

    * `mon_num_enable` - Enable or disable displaying which monitor input the alert was recieved on in the webhook message

    * `filter_display_enable` - Enable or disable displaying which alert filter was matched when the alert was recieved in the webhook message

* `telnet`
    * `ip` - IP of your Lantronix or similar serial server
    * `port` - Port that you can telnet into for access to the endec serial port

* `mysql`
    * `server_ip` - IP of your MySQL server
    * `user` - Username of your MySQL user
    * `pass` - Password of your MySQL user