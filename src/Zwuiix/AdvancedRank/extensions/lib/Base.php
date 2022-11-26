<?php

namespace Zwuiix\AdvancedRank\extensions\lib;

use Cassandra\Date;
use pocketmine\Server;
use Zwuiix\AdvancedRank\data\sub\PluginData;
use Zwuiix\AdvancedRank\player\RankPlayer;

class Base
{

    /**
     * @param RankPlayer $player
     * @param string $message
     * @return string|array|string[]
     */
    public static function replace(RankPlayer $player, string $message): string|array
    {
        $user=$player->getInitialPlayer();
        date_default_timezone_set(PluginData::get()->get("timezone"));
        $replace=[
            "{PLAYER}" => $user->getDisplayName(),
            "{PING}" => $user->getNetworkSession()->getPing(),
            "{NAME}" => $user->getName(),
            "{WORLD}" => $user->getWorld()->getFolderName(),
            "{X}" => $user->getPosition()->getX(),
            "{Y}" => $user->getPosition()->getY(),
            "{Z}" => $user->getPosition()->getZ(),
            "{IP}" => $user->getNetworkSession()->getIp(),
            "{PORT}" => $user->getNetworkSession()->getPort(),
            "{UID}" => $user->getUniqueId(),
            "{XUID}" => $user->getXuid(),
            "{UUID}" => $user->getNetworkSession()->getPlayerInfo()->getUuid(),
            "{HEALTH}" => $user->getHealth(),
            "{MAX_HEALTH}" => $user->getMaxHealth(),
            "{FOOD}" => $user->getHungerManager()->getFood(),
            "{MAX_FOOD}" => $user->getHungerManager()->getMaxFood(),
            "{SATURATION}" => $user->getHungerManager()->getSaturation(),
            "{GAMEMODE}" => $user->getGamemode()->name(),
            "{SCALE}" => $user->getScale(),
            "{XP}" => $user->getXpManager()->getXpLevel(),
            "{ID}" => $user->getId(),
            "{ITEM_CUSTOMNAME}" => $user->getInventory()->getItemInHand()->getCustomName(),
            "{ITEM_NAME}" => $user->getInventory()->getItemInHand()->getName(),
            "{ITEM_ID}" => $user->getInventory()->getItemInHand()->getId(),
            "{COUNT}" => $user->getInventory()->getItemInHand()->getCount(),
            "{ONLINE}" => count(Server::getInstance()->getOnlinePlayers()),
            "{MAX_ONLINE}" => Server::getInstance()->getMaxPlayers(),
            "{TPS}" => Server::getInstance()->getTicksPerSecondAverage(),
            "{YEARS}" => date("Y"),
            "{MONTHS_NAME}" => date("F"),
            "{MONTHS}" => date("m"),
            "{DAYS}" => date("j"),
            "{HOURS}" => date("H"),
            "{MINUTE}" => date("i"),
            "{SECOND}" => date("s"),
        ];
        return str_replace(array_keys($replace), array_values($replace), $message);
    }
}