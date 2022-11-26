# AdvancedRank
[![Discord](https://img.shields.io/badge/chat-on%20discord-7289da.svg)](https://discord.gg/YfyfH6fdyv)

AdvancedRank is a plugin that allows you to add ranks to your server, it is quite simple to use, easy to handle...
Creation of rank in json or yaml config, lang system in INI and others, if we summarize, it is perfect for you!

## commands

| Command Name             | Command Description               | Permission                         |
|--------------------------|-----------------------------------|------------------------------------|
| `/rank`                  | Rank help command.                | advancedrank.rank                  |
| `/rank create`           | Create a new Rank.                | advancedrank.rank.create           |
| `/rank delete`           | Delete a existed rank.            | advancedrank.rank.delete           |
| `/rank set`              | Define player rank.               | advancedrank.rank.set              |
| `/rank give`             | Give a rank to player & broadcast | advancedrank.rank.give             |
| `/rank info`             | Info of a rank.                   | advancedrank.rank.info             |
| `/rank addpermission`    | Add a rank permission in game     | advancedrank.rank.addpermission    |
| `/rank removepermission` | Remove a rank permission in game  | advancedrank.rank.removepermission |
| `/rank list`             | List of rank                      | advancedrank.rank.list             |
| `/rank user`             | Information of player             | advancedrank.rank.user             |
| `/rank manage`           | Use all commands                  | advancedrank.rank.manage           |

## Features

| Feature                            | AdvancedRank | PurePerms | RankSystem |
|------------------------------------|--------------|-----------|------------|
| `MySQL Support`                    | ❌            | ✔         | ✔          |
| `TempRank`                         | ✔            | ✔         | ✔          |
| `Easy to use`                      | ✔            | ❌         | ✔          |
| `Easy Rank Creation / Edit System` | ✔            | ❌         | ✔          |
| `Multi-language support`           | ✔            | ❌         | ✔          |
| `Permissions per User`             | ✔            | ✔         | ✔          |
| `Extension for developer`          | ✔            | ❌         | ✔          |
| `FormUI`                           | ✔            | ❌         | ❌          |
| `Choice to format rank (json/yml)` | ✔            | ❌         | ❌          |
| `Priority rank`                    | ✔            | ❌         | ❌          |
| `Command auto-complete`            | ✔            | ❌         | ❌          |


## Future additions

| Name              | Description                                | Type    |
|-------------------|--------------------------------------------|---------|
| `Full customise`  | Customise ui, command description & others | system  |
| `Others langs`    | Add an others lang                         | lang    |

## Additional plugins
| Name          | Usage               | Download                                            |
|---------------|---------------------|-----------------------------------------------------|
| EconomyAPI    | Bank system         | [Download](https://poggit.pmmp.io/p/EconomyAPI)     |
| FactionMaster | Faction system      | [Download](https://poggit.pmmp.io/p/FactionMaster/) |
| PiggyFactions | Faction system      | [Download](https://poggit.pmmp.io/p/PiggyFactions/) |
| SimpleFaction | Faction system      | [Download](https://poggit.pmmp.io/p/SimpleFaction/) |
| InfoTag       | Nametag integration | [Download](https://poggit.pmmp.io/p/InfoTag)        |

## Translators
- **French** - [@Zwuiix-cmd](https://github.com/Zwuiix-cmd)
- **Others** - [Offer your help](https://discord.gg/JeUU7c5v)

## Contributors
- [@Zwuiix-cmd](https://github.com/Zwuiix-cmd)
- [@Slayer-cmd](https://github.com/Slayer-cmd)
- [@SenseiTarzan](https://github.com/SenseiTarzan)


### Exemple of config.yml
```yaml
---
#               _                               _ _____             _
#     /\      | |                             | |  __ \           | |
#    /  \   __| |_   ____ _ _ __   ___ ___  __| | |__) |__ _ _ __ | | __
#   / /\ \ / _` \ \ / / _` | '_ \ / __/ _ \/ _` |  _  // _` | '_ \| |/ /
#  / ____ \ (_| |\ V / (_| | | | | (_|  __/ (_| | | \ \ (_| | | | |   <
# /_/    \_\__,_| \_/ \__,_|_| |_|\___\___|\__,_|_|  \_\__,_|_| |_|_|\_\
#
#

default-rank-type: "json"
default-rank: "Player"

# Activate or deactivate the forms,
# if they are activated you just have to make the command without the arguments,
# a **CustomForm** is created automatically!
form: "true"

# You can add your own language, you just have to create an archive in .ini and respect the name in the lang folder!
langage: "fr"

# Enables or disables the use of the prefix!
use-prefix: "true"

# This allows you to use the {DAYS}-{MINUTE}-{SECOND}
timezone: "Europe/Paris"

extensions:
EconomyAPI: "false"
PiggyFactions: "false"
SimpleFaction: "false"
FactionMaster: "false"
InfoTag: "false"
...
```

### Rank exemple (json)
```json
{
  "name": "Player",
  "priority": 0,
  "permissions": [],
  "chat-format": "§7{RANK} {PLAYER}§f: §7{MSG}",
  "nametag-format": "§7{RANK} {PLAYER}"
}
```

### Rank exemple (yml)
```yaml
---
name: "Player"
priority: 0
permissions: []
chat-format: "{RANK} {PLAYER}: {MSG}"
nametag-format: "{RANK} {PLAYER}"
...
```

#### Lang file exemple (French)
```ini
[Information]
lang=fr
prefix="{GOLD}Rank {WHITE}>> "

[Rank]
please-ingame="{RED}Désolée, vous devez être connecter en jeux pour faire cela!"
not-connected="{RED}Désolée, ce joueur n'est pas connecté!"
rank-not-exist="{RED}Désolée, le grade n'existe pas!"

form-not-enabled="{RED}Désolée, les form ne sont pas activer!"

set="{GREEN}Vous avez défini le rank {YELLOW}{RANK}{GREEN} a {YELLOW}{PLAYER}{GREEN} avec succès!"
give="{GREEN}Vous avez donner le rank {YELLOW}{RANK}{GREEN} a {YELLOW}{PLAYER}{GREEN} avec succès!"
broadcast-give="{YELLOW}{PLAYER}{WHITE} vien d'obtenir le grade {YELLOW}{RANK}{WHITE}!"

create="{GREEN}Le grade {YELLOW}{ARGS} {GREEN}a été crée avec succès!"
delete="{GREEN}Le grade {YELLOW}{ARGS} {GREEN}a été supprimé avec succès!"

addpermission="{GREEN}Vous avez ajouté la permission {YELLOW}{ARGS} {GREEN}avec succès!"
removepermission="{GREEN}Vous avez retiré la permission {YELLOW}{ARGS} {GREEN}avec succès!"
exist-permission="{RED}Désolée, la permission {YELLOW}{ARGS}{RED} existe déjà!"
not-exist-permission="{RED}Désolée, la permission {YELLOW}{ARGS}{RED} n'existe pas!"

list="{GREEN}Voici la liste des ranks: {YELLOW}{RANKS_LIST}"

info="{GREEN}Voici les informations concernant le rank {YELLOW}{RANK_NAME}{WHITE}:"
priority="Priorité: {LIGHT_PURPLE}{RANK_PRIORITY}"
permissions="Permissions: {BLUE}{RANK_PERMISSIONS}"
players="Players: {YELLOW}{RANK_PLAYERS}"

user-info="{WHITE}Le joueur {YELLOW}{PLAYER} {WHITE}possède le grade {YELLOW}{RANK}{WHITE}!"

adduserpermission="{GREEN}Vous avez ajouté la permission {YELLOW}{ARGS} {GREEN} à {YELLOW}{PLAYER}{GREEN} avec succès!"
removeuserpermission="{GREEN}Vous avez retiré la permission {YELLOW}{ARGS} {GREEN}à {YELLOW}{PLAYER}{GREEN} avec succès!"
```

### AdvancedRankExtension
```php
use Zwuiix\AdvancedRank\extensions\AdvancedRankExtension;

# Update all nametag
/** @return void */
AdvancedRankExtension::getInstance()->updateAllNameTag();

# Get specific rank (Rank::class)
/** @return \Zwuiix\AdvancedRank\rank\Rank $player */
AdvancedRankExtension::getInstance()->getRank("Player");

# Get Player Rank Name
/** @param \pocketmine\player\Player $player */
AdvancedRankExtension::getInstance()->getPlayerRank($player);

# get ALl rank registered
/** @return array */
AdvancedRankExtension::getInstance()->getAllRanks();

# get list of player have rank
/** @param \Zwuiix\AdvancedRank\rank\Rank $rank */
AdvancedRankExtension::getInstance()->getPlayersByRank($rank);
```
