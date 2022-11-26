<?php

namespace Zwuiix\AdvancedRank\extensions\lib;

use DaPigGuy\PiggyFactions\players\PlayerManager;
use Zwuiix\AdvancedRank\player\RankPlayer;

class PiggyFactions
{
    /**
     * @param RankPlayer $player
     * @return string
     */
    public static function getPlayerFaction(RankPlayer $player): string
    {
        $member=PlayerManager::getInstance()->getPlayer($player->getInitialPlayer());
        $faction = $member?->getFaction();
        if(!is_null($faction))return $faction->getName();
        return "...";
    }

    /**
     * @param RankPlayer $player
     * @return string
     */
    public static function getPlayerRank(RankPlayer $player): string
    {
        $member = PlayerManager::getInstance()->getPlayer($player->getInitialPlayer());
        $symbol = $member == null ? null : \DaPigGuy\PiggyFactions\PiggyFactions::getInstance()->getTagManager()->getPlayerRankSymbol($member);
        if(is_null($member) or is_null($symbol)) return "";
        return $symbol;
    }

    /**
     * @param RankPlayer $player
     * @return float|string
     */
    public static function getFactionPower(RankPlayer $player): float|string
    {
        $member=PlayerManager::getInstance()->getPlayer($player->getInitialPlayer());
        $faction = $member?->getFaction();
        if(!is_null($faction))return round($faction->getPower(), 2);
        return 0;
    }

    /**
     * @param RankPlayer $player
     * @param string $message
     * @return string|array|string[]
     */
    public static function replace(RankPlayer $player, string $message): string|array
    {
        $replace=[
            "{FAC_NAME}" => self::getPlayerFaction($player),
            "{FAC_RANK}" => self::getPlayerRank($player),
            "{FAC_POWER}" => self::getFactionPower($player),
        ];
        return str_replace(array_keys($replace), array_values($replace), $message);
    }
}