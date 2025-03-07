from distutils.command.config import config
import eas_codes_converter
import json
from discord_webhook import DiscordWebhook, DiscordEmbed

with open("settings.json", "r") as configfile:
    configdata = json.load(configfile)

RX_URL=configdata['webhook']['rx_url']
TX_URL=configdata['webhook']['tx_url']

# Load this in from settings.json

ZCZC_ENABLE = configdata['webhook']['zczc_str_enable']
FILTER_ENABLE = configdata['webhook']['filter_display_enable']
MON_NUM_ENABLE = configdata['webhook']['mon_num_enable']
TITLE_LINK_ENABLE = configdata['webhook']['title_link_to_webui']
WEB_URL = configdata['general']['webui_url']

def generateRXAlertEmbed(input_data):

    print("webhook_generator: Remote alert detected...executing remote alert webhook...")

    EVENT = eas_codes_converter.SAME2txt(input_data[4][2])

    webhook = DiscordWebhook(url=RX_URL)
    
    if TITLE_LINK_ENABLE:
        embed = DiscordEmbed(title=f'{"".join(EVENT[0])}', url=f'{"".join(WEB_URL)}', description=f'{"".join(input_data[1])}', color=f'{"".join(EVENT[1])}')
    else:
        embed = DiscordEmbed(title=f'{"".join(EVENT[0])}', description=f'{"".join(input_data[1])}', color=f'{"".join(EVENT[1])}')

    embed.add_embed_field(name='Timestamp: ', value=f'{"".join(input_data[0])}')

    if MON_NUM_ENABLE:
        embed.add_embed_field(name='Monitor Channel: ', value=f'{"".join(input_data[2])}')

    if FILTER_ENABLE:
        embed.add_embed_field(name='Filter Match: ', value=f'{"".join(input_data[1])}')

    if ZCZC_ENABLE:
        embed.add_embed_field(name='Raw: ', value=f'{"-".join(input_data[4])}')

    webhook.add_embed(embed)

    response = webhook.execute()

def generateLocalAlertEmbed(input_data):

    print("webhook_generator: Local alert/alert relay detected...executing local alert webhook...")

    EVENT = eas_codes_converter.SAME2txt(input_data[2][2])

    webhook = DiscordWebhook(url=TX_URL)

    # you can set the color as a decimal (color=242424) or hex (color='03b2f8') number
    if TITLE_LINK_ENABLE:
        embed = DiscordEmbed(title=f'{"".join(EVENT[0])}', url=f'{"".join(WEB_URL)}', description=f'{"".join(input_data[1])}', color=f'{"".join(EVENT[1])}')
    else:
        embed = DiscordEmbed(title=f'{"".join(EVENT[0])}', description=f'{"".join(input_data[1])}', color=f'{"".join(EVENT[1])}')
        
    embed.set_footer(text='DigiDEC v2 by trevor229')
    # Embed field names must have text in them :sadge:
    embed.add_embed_field(name='Timestamp: ', value=f'{"".join(input_data[0])}')

    if ZCZC_ENABLE:
        embed.add_embed_field(name='Raw: ', value=f'{"-".join(input_data[2])}')

    # add embed object to webhook
    webhook.add_embed(embed)

    response = webhook.execute()
    # Response code from Discord API