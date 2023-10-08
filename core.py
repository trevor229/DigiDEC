import telnetlib
import unicodedata
import re
import json
import mysql.connector
import sys
import os
# Local imports
import webhook_generator
import eas_codes_converter

try:
    with open("settings.json", "r") as configfile:
        configdata = json.load(configfile)
        os.system('cls' if os.name == 'nt' else 'clear')
        print("\nsettings.json loaded successfully!\n")
        print("""
                 /$$$$$$$  /$$           /$$ /$$$$$$$  /$$$$$$$$  /$$$$$$ 
                | $$__  $$|__/          |__/| $$__  $$| $$_____/ /$$__  $$
                | $$  \ $$ /$$  /$$$$$$  /$$| $$  \ $$| $$      | $$  \__/
                | $$  | $$| $$ /$$__  $$| $$| $$  | $$| $$$$$   | $$      
                | $$  | $$| $$| $$  \ $$| $$| $$  | $$| $$__/   | $$      
                | $$  | $$| $$| $$  | $$| $$| $$  | $$| $$      | $$    $$
                | $$$$$$$/| $$|  $$$$$$$| $$| $$$$$$$/| $$$$$$$$|  $$$$$$/
                |_______/ |__/ \____  $$|__/|_______/ |________/ \______/ 
                               /$$  \ $$                                  
                              |  $$$$$$/                                  
                               \______/                                   
            """)
        print('\n')
        print("DigiDEC v0.1 by trevor229 | https://github.com/trevor229")
        print("\nSAGE EAS Endec Serial/Telnet Logging Software with Discord Webhook integration")
        print('\n')
except FileNotFoundError:
    print("settings.json not found! Did you reanme the example file?")


# Serial Server IP here
HOST=configdata['telnet']['ip']

# Remote port here. 10001 and 10002 for UDS200
PORT=configdata['telnet']['port']

tn = telnetlib.Telnet()

tn.open(HOST, port=PORT)

# Use unicodedata library to remove unicode characters from provided text (ie \r, \n)
def remove_control_characters(s):
    return "".join(ch for ch in s if unicodedata.category(ch)[0]!="C")

# Remove <ENDECSTART> and <ENDECEND> from provided string
def remove_header_footer(txt):
    return txt.removeprefix("<ENDECSTART>").removesuffix("<ENDECEND>")

def sentAlert(rawdata):

    MAIN_TEXT = re.findall(r'(?:A Broadcast|The National|The Civil|A Primary Entry)[^\)]+.', rawdata)
    LOCAL = re.findall(r'^.*\d\d:\d\d:\d\d',"".join(rawdata))
    ZCZC_TEXT = re.findall(r'ZCZC.\S+', rawdata)
    ZCZC_TEXT = re.split(r'\b[-+]',"".join(ZCZC_TEXT))

    COMBINED = [LOCAL,MAIN_TEXT,ZCZC_TEXT]

    EVENT = eas_codes_converter.SAME2txt(ZCZC_TEXT[2])

    
    try:
        # Create new connection. Happens every time the sentAlert function is called
        dbase= mysql.connector.connect(
            host = configdata['mysql']['server_ip'],
            user = configdata['mysql']['user'],
            passwd = configdata['mysql']['pass']
        )
        cursorObject = dbase.cursor()
        cursorObject.execute("USE digidec_tx_log")

        SQL = "INSERT INTO alerts (EVENT_TXT,EVENT_CODE,DESCR,ZCZC_STR,TYPE) VALUES (%s,%s,%s,%s,%s)"  # Note: no quotes
        data = (EVENT[0],ZCZC_TEXT[2],''.join(MAIN_TEXT),'-'.join(ZCZC_TEXT),EVENT[2])
        
        cursorObject.execute(SQL,data)
        print("alert logged to SQL db!\n")
        
        # Important to commit our data! Wont be in the fucking db otherwise.... ask me how I realized that.
        dbase.commit()
        # Close our connection and cursor to avoid leaving open a connection and timing out/wasting resources.
        dbase.close()
    except Exception as e: 
        print('\n')
        print(e)


    # POST output to Discord webhook
    webhook_generator.determineType(COMBINED, 1)

def rxAlert(rawdata):

    MAIN_TEXT = re.findall(r'(?:A Broadcast|The National|The Civil|A Primary Entry)[^\)]+.', rawdata)

    FILTER_MATCHED = re.findall(r'(?<=Matched Filter )(.*)(?=A Broadcast|The National|The Civil|A Primary Entry)', "".join(rawdata))
    MON_NUM = re.findall(r'(?<=on monitor )(..)(?=Matched Filter)', "".join(rawdata))
    LOCAL = re.findall(r'^.*\d\d:\d\d:\d\d',"".join(rawdata))
    ZCZC_TEXT = re.findall(r'ZCZC.\S+', rawdata)
    ZCZC_TEXT = re.split(r'\b[-+]',"".join(ZCZC_TEXT))
    
    EVENT = eas_codes_converter.SAME2txt(ZCZC_TEXT[2])

    # Remove last null item in list of ZCZC_TEXT
    del ZCZC_TEXT[-1]

    COMBINED = [LOCAL,FILTER_MATCHED,MON_NUM,MAIN_TEXT,ZCZC_TEXT]

    try:
        # Create new connection. Happens every time the sentAlert function is called
        dbase= mysql.connector.connect(
            host = configdata['mysql']['server_ip'],
            user = configdata['mysql']['user'],
            passwd = configdata['mysql']['pass']
        )
        cursorObject = dbase.cursor()
        cursorObject.execute("USE digidec_rx_log")

        SQL = "INSERT INTO alerts (EVENT_TXT,EVENT_CODE,FILTER,MON,DESCR,ZCZC_STR,TYPE) VALUES (%s,%s,%s,%s,%s,%s,%s)"  # Note: no quotes
        data = (EVENT[0],ZCZC_TEXT[2],''.join(FILTER_MATCHED),''.join(MON_NUM),''.join(MAIN_TEXT),'-'.join(ZCZC_TEXT),EVENT[2])
        
        cursorObject.execute(SQL,data)
        print("alert logged to SQL db!\n")
        
        # Important to commit our data! Wont be in the fucking db otherwise.... ask me how I realized that.
        dbase.commit()
        # Close our connection and cursor to avoid leaving open a connection and timing out/wasting resources.
        dbase.close()
    except Exception as e: 
        print('\n')
        print(e)

    # POST output to Discord webhook
    webhook_generator.determineType(COMBINED, 2)

# async is for nerds
while True:
    #selection = input("\nPress q to quit...")
    #if selection == "Q" or selection == "q":
    #    print("Quitting")
    #    sys.exit()
    # telnetlib read stream until ENDECEND is recieved then continue on
    output = tn.read_until(b'<ENDECEND>')
    # Decode bytes-like object into usable ascii string
    NICERDATA = output.decode("ascii")
    # Remove all newline and other control characters from decoded output
    NICERDATA = remove_control_characters(NICERDATA)
    NICERDATA = remove_header_footer(NICERDATA)

    if NICERDATA.startswith("Local") or NICERDATA.startswith("Old"):
        print("\nLocal or Old Alert Sent/Relayed! \n")
        sentAlert(NICERDATA)
    elif NICERDATA.startswith("Alert Received"):
        print("\nAlert Received on Input! \n")
        rxAlert(NICERDATA)
    elif NICERDATA.startswith("Alert sent"):
        print("\nAlert Relayed by Endec!\n")
        #rxAlert(NICERDATA)
    else:
        print("fuckinuhhhhhhhhhhhh")
        print(NICERDATA)