<?php

namespace Zwuiix\AdvancedRank\extensions\lib;

use onebone\economyapi\EconomyAPI as EcoAPI;
use Zwuiix\AdvancedRank\player\RankPlayer;

class EconomyAPI
{
    /**
     * @param RankPlayer $player
     * @return float|bool
     */
    public static function getMoney(RankPlayer $player): float|bool
    {
        return EcoAPI::getInstance()->myMoney($player->getInitialPlayer());
    }

    /**
     * @param RankPlayer $player
     * @param string $message
     * @return string|array|string[]
     */
    public static function replace(RankPlayer $player, string $message): string|array
    {
        $replace=[
            "{MONEY}" => self::getMoney($player),
        ];
        return str_replace(array_keys($replace), array_values($replace), $message);
    }
}