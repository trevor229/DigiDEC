![Main project logo](/logos/digidec_logo_vector.png)
# DigiDEC - SAGE EAS Endec Serial/Telnet Logging Software with Discord Webhook integration

### DigiDEC is software written in Python to parse, log, and display emergency alerts recieved by the Sage EAS ENDEC model 1822 via local serial connection (WIP) or a remote serial server.

![Screenshot of an example discord webhook](images/example_alert.png)

# Features

✔️ Telnet based serial server support

✔️ MySQL database logging

✔️ PHP based web front end pages to review alerts

✔️ Basic alert reception statistics

✔️ Per-event and by year data sorting

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

# Database Schema

```
CREATE DATABASE alerts;
```

```
CREATE TABLE digidec_rx_log(
    EVENT_TXT varchar(50), 
    EVENT_CODE char(3), 
    FILTER text, 
    MON tinytext, 
    DESCR text, 
    ZCZC_STR text,
    TYPE varchar(8),
    TIMESTP datetime
);
```
```
CREATE TABLE digidec_tx_log(
    EVENT_TXT varchar(50), 
    EVENT_CODE char(3), 
    FILTER text, 
    MON tinytext, 
    DESCR text, 
    ZCZC_STR text,
    TYPE varchar(8),
    TIMESTP datetime
);
```

# Installation

1. Clone the repo into a suitable directory where you wish to run the main python scripts

2. Install/ensure the python dependencies listed above are on your target system (Ubuntu server is recommended) and PHP is functional for your apache install

3. Create the directory `/var/www/html/digidec` and copy the contents of `html_front_end` into it

4. Copy the `10-digidec_web_config.conf` file to your `/etc/apache2/sites-available` directory
    * Make sure to check the apache site configs if you are using a different webroot!

5. Link the conf file from sites-available to sites-enabled using `sudo ln /etc/apache2/sites-available/10-digidec_web_conf.conf /etc/apache2/sites-enabled` to enable it in apache

    * Be sure to run `sudo service apache2 reload` to reload the configs after linking

6. Rename `DEFAULT_db_creds.ini` to `db_creds.ini` and populate with the appropriate credentials and database names if different from default

7. Run the `core.py` script with python3 to check functionality

8. If everything functions as intended, copy the `digidec.service` file to `/etc/systemd/system` and run `sudo systemctl daemon-reload` and `sudo systemctl enable digidec.service` to enable running at startup. If the service isn't already running, run `sudo systemctl start digidec.service`


# Configuration

## __Before anything, if you are using a Lantronix serial server, read this!__
By default, the UDS200 (And 2000 I believe) cache unread bytes recieved on the serial ports and output them when the telnet interface is accessed. We dont want this! It can cause duplicates. To turn this feature off (to the best of my knowledge), do the following:

* Telnet in on the configuration interface (usually port 9999)
* press 1 or 2 to select which channel/port your endec is on
* ensure your baudrate is matching the endec's
* keep pressing enter until you reach FlushMode and set the value to `11`, which in the manual corresponds (in binary) to turning off the caching feature
* once you are back at the main configuration screen, be sure to save your settings!

#

## Configuration for the MySQL database and PHP database names are found within the `DEFAULT_db_creds.ini` file. 

* You MUST rename this to `db_creds.ini` and populate it with the appropriate values for your setup before the application will function!

#

## Configuration parameters for the base application are found within the `settings.json` file
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

#

# Screenshots

![SCreenshot of the recieved alerts UI](images/recieved_ui.png)
![Screenshot of the sent alerts UI](images/sent_ui.png)
![Screenshot of the stats UI](images/stats_ui.png)
![Screenshot of the about page UI](images/about_ui.png)