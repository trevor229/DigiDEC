from distutils.command.config import config
import eas_codes_converter
import json
from discord_webhook import DiscordWebhook, DiscordEmbed

with open("settings.json", "r") as configfile:
    configdata = json.load(configfile)

WH_URL=configdata['webhook']['url']

# Load this in from settings.json
EMBED_ENABLE = configdata['webhook']['zczc_str_enable']
FILTER_ENABLE = configdata['webhook']['filter_display_enable']
MON_NUM_ENABLE = configdata['webhook']['mon_num_enable']

def generateRXAlertEmbed(input_data):
    EVENT = eas_codes_converter.SAME2txt(input_data[4][2])

    webhook = DiscordWebhook(url=WH_URL)
    
    embed = DiscordEmbed(title=f'{"".join(EVENT[0])}', description=f'{"".join(input_data[3])}', color=f'{"".join(EVENT[1])}')

    embed.add_embed_field(name='Timestamp: ', value=f'{"".join(input_data[0])}')

    if MON_NUM_ENABLE:
        embed.add_embed_field(name='Monitor Channel: ', value=f'{"".join(input_data[2])}')

    if FILTER_ENABLE:
        embed.add_embed_field(name='Filter Match: ', value=f'{"".join(input_data[1])}')

    if EMBED_ENABLE:
        embed.add_embed_field(name='Raw: ', value=f'{"-".join(input_data[4])}')

    webhook.add_embed(embed)

    response = webhook.execute()

def generateLocalAlertEmbed(input_data):
    EVENT = eas_codes_converter.SAME2txt(input_data[2][2])

    webhook = DiscordWebhook(url=WH_URL)

    # you can set the color as a decimal (color=242424) or hex (color='03b2f8') number
    embed = DiscordEmbed(title=f'{"".join(EVENT[0])}', description=f'{"".join(input_data[1])}', color=f'{"".join(EVENT[1])}')
    embed.set_footer(text='DigiDEC v0.1 by trevor229')
    # Embed field names must have text in them :sadge:
    embed.add_embed_field(name='Timestamp: ', value=f'{"".join(input_data[0])}')

    if EMBED_ENABLE:
        embed.add_embed_field(name='Raw: ', value=f'{"-".join(input_data[2])}')

    # add embed object to webhook
    webhook.add_embed(embed)

    response = webhook.execute()
    # Response code from Discord API
    #print(response)

def determineType(alert_data, alert_type):
    if alert_type == 1:
        print("webhook_generator: Local alert/alert relay detected...executing local alert webhook...")
        generateLocalAlertEmbed(alert_data)
    elif alert_type == 2:
        print("webhook_generator: Remote alert detected...executing remote alert webhook...")
        generateRXAlertEmbed(alert_data)
