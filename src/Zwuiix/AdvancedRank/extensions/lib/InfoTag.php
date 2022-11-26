<?php

namespace Zwuiix\AdvancedRank\extensions\lib;

use AmmyRQ\InfoTag\API;
use Zwuiix\AdvancedRank\player\RankPlayer;

class InfoTag
{
    public static function getDevice(RankPlayer $player)
    {
        if(array_key_exists($player->getInitialPlayer()->getName(), API::$playerDevices)){
            return API::$devices[API::$playerDevices[$player->getInitialPlayer()->getName()]];
        }
        return "Unknown";
    }

    /**
     * @param RankPlayer $player
     * @param string $message
     * @return string|array|string[]
     */
    public static function replace(RankPlayer $player, string $message): string|array
    {
        $replace=[
            "{DEVICE}" => self::getDevice($player),
        ];
        return str_replace(array_keys($replace), array_values($replace), $message);
    }
}