# MySQL logger

import json

with open("settings.json", "r") as configfile:
    configdata = json.load(configfile)

# Considering connection is gonna only be made once, probably forgo variable assignment here and just have the json reference in the server login function call
SERVER_IP = configdata['mysql']['server_ip']
USERNAME = configdata['mysql']['user']
PASSWORD = configdata['mysql']['pass']

def log2MySQLServer():
    print("bruh")

def bootstrapDatabase():
    print("moment")