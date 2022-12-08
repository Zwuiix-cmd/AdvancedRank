<?php

namespace Zwuiix\AdvancedRank\extensions\lib;

use Ayzrix\SimpleFaction\API\FactionsAPI;
use Zwuiix\AdvancedRank\player\RankPlayer;

/*
 *  A big thank you to @Ayzrix for this, I just modify them my way :p
 */
class SimpleFaction
{
    /**
     * @param RankPlayer $player
     * @return string
     */
    public static function getPlayerFaction(RankPlayer $player): string
    {
        if(!FactionsAPI::isInFaction($player->getInitialPlayer()->getName())) return "...";
        return FactionsAPI::getFaction($player->getInitialPlayer()->getName());
    }

    /**
     * @param RankPlayer $player
     * @return string
     */
    public static function getPlayerRank(RankPlayer $player): string
    {
        if(!FactionsAPI::isInFaction($player->getInitialPlayer()->getName())) return "";
        return FactionsAPI::getRank($player->getInitialPlayer()->getName());
    }

    /**
     * @param RankPlayer $player
     * @return string|int
     */
    public static function getFactionPower(RankPlayer $player): int|string
    {
        if(!FactionsAPI::isInFaction($player->getInitialPlayer()->getName())) return 0;
        return FactionsAPI::getPower(FactionsAPI::getFaction($player->getInitialPlayer()->getName()));
    }

    /**
     * @param RankPlayer $player
     * @return string|int
     */
    public static function getFactionMoney(RankPlayer $player): int|string
    {
        if(!FactionsAPI::isInFaction($player->getInitialPlayer()->getName())) return 0;
        return FactionsAPI::getMoney(FactionsAPI::getFaction($player->getInitialPlayer()->getName()));
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
            "{FAC_MONEY}" => self::getFactionMoney($player),
        ];
        return str_replace(array_keys($replace), array_values($replace), $message);
    }
}