import json

with open("settings.json", "r") as configfile:
    configdata = json.load(configfile)

# Method to respond with descriptive text from SAME 3 letter code

# Define embed colors in hex

RED=configdata['embed']['alert_colors']['red_hex']
ORG=configdata['embed']['alert_colors']['org_hex']
YEL=configdata['embed']['alert_colors']['yel_hex']
TEST=configdata['embed']['alert_colors']['test_hex']
UNK=configdata['embed']['alert_colors']['unknown_hex']

# Thank you Python 3.10+ for switch statements
def SAME2txt(code):
    match code:
        case "ADR":
            return ["Administrative Message", YEL, "advisory"]
        case "AVA":
            return ["Avalanche Watch", ORG, "watch"]
        case "AVW":
            return ["Avalanche Warning", RED, "warning"]
        case "BLU":
            return ["Blue Alert", RED, "advisory"]
        case "BZW":
            return ["Blizzard Warning", RED, "warning"]
        case "CAE":
            return ["Child Abduction Emergency", YEL, "advisory"]
        case "CDW":
            return ["Civil Danger Warning", RED, "warning"]
        case "CEM":
            return ["Civil Emergency Message", RED, "warning"]
        case "CFA":
            return ["Coastal Flood Watch", ORG, "watch"]
        case "CFW":
            return ["Coastal Flood Warning", RED, "warning"]
        case "DMO":
            return ["Practice/Demo Warning", TEST, "test"]
        case "DSW":
            return ["Dust Storm Warning", RED, "warning"]
        case "EAN":
            return ["Emergency Action Notification", RED, "warning"]
        case "EAT":
            return ["Emergency Action Termination", YEL, "advisory"]
        case "EQW":
            return ["Earthquake Warning", RED, "warning"]
        case "EVI":
            return ["Immediate Evacuation", RED, "warning"]
        case "EWW":
            return ["Extreme Wind Warning", RED, "warning"]
        case "FFA":
            return ["Flash Flood Watch", ORG, "watch"]
        case "FFS":
            return ["Flash Flood Statement", YEL, "advisory"]
        case "FFW":
            return ["Flash Flood Warning", RED, "warning"]
        case "FLA":
            return ["Flood Watch", ORG, "watch"]
        case "FLS":
            return ["Flood Statement", YEL, "advisory"]
        case "FLW":
            return ["Flood Warning", RED, "warning"]
        case "FRW":
            return ["Fire Warning", RED, "warning"]
        case "FSW":
            return ["Flash Freeze Warning", RED, "warning"]
        case "FZW":
            return ["Freeze Warning", RED, "warning"]
        case "HLS":
            return ["Hurricane Local Statement", YEL, "advisory"]
        case "HMW":
            return ["Hazardous Materials Warning", RED, "warning"]
        case "HUA":
            return ["Hurricane Watch", ORG, "watch"]
        case "HUW":
            return ["Hurricane Warning", RED, "warning"]
        case "HWA":
            return ["High Wind Watch", ORG, "watch"]
        case "HWW":
            return ["High Wind Warning", RED, "warning"]
        case "LAE":
            return ["Local Area Emergency", YEL, "advisory"]
        case "LEW":
            return ["Law Enforcement Warning", RED, "warning"]
        case "MEP":
            return ["Missing Endangered Persons", YEL, "advisory"]
        case "NAT":
            return ["National Audible Test", TEST, "test"]
        case "NIC":
            return ["National Information Center", YEL, "advisory"]
        case "NMN":
            return ["Network Notification Message", YEL, "advisory"]
        case "NPT":
            return ["National Periodic Test", TEST, "test"]
        case "NST":
            return ["National Silent Test", TEST, "test"]
        case "NUW":
            return ["Nuclear Power Plant Warning", RED, "warning"]
        case "RHW":
            return ["Radiological Hazard Warning", RED, "warning"]
        case "RMT":
            return ["Required Monthly Test", TEST, "test"]
        case "RWT":
            return ["Required Weekly Test", TEST, "test"]
        case "SMW":
            return ["Special Marine Warning", RED, "warning"]
        case "SPS":
            return ["Special Weather Statement", YEL, "advisory"]
        case "SPW":
            return ["Shelter In-Place Warning", RED, "warning"]
        case "SQW":
            return ["Snow Squall Warning", RED, "warning"]
        case "SSA":
            return ["Storm Surge Watch", ORG, "watch"]
        case "SSW":
            return ["Storm Surge Warning", RED, "warning"]
        case "SVA":
            return ["Severe Thunderstorm Watch", ORG, "watch"]
        case "SVR":
            return ["Severe Thunderstorm Warning", RED, "warning"]
        case "SVS":
            return ["Severe Weather Statement", YEL, "advisory"]
        case "TOA":
            return ["Tornado Watch", ORG, "watch"]
        case "TOR":
            return ["Tornado Warning", RED, "warning"]
        case "TRA":
            return ["Tropical Storm Watch", ORG, "watch"]
        case "TRW":
            return ["Tropical Storm Warning", RED, "warning"]
        case "TSA":
            return ["Tsunami Watch", ORG, "watch"]
        case "TSW":
            return ["Tsunami Warning", RED, "warning"]
        case "VOW":
            return ["Volcano Warning", RED, "warning"]
        case "WSA":
            return ["Winter Storm Watch", ORG, "watch"]
        case "WSW":
            return ["Winter Storm Warning", RED, "warning"]
        case _:
            return ["Unknown Alert", UNK, "unknown"]