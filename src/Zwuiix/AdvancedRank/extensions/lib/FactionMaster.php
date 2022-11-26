<?php

namespace Zwuiix\AdvancedRank\extensions\lib;

use ShockedPlot7560\FactionMaster\API\MainAPI;
use ShockedPlot7560\FactionMaster\Database\Entity\FactionEntity;
use ShockedPlot7560\FactionMaster\Database\Entity\UserEntity;
use ShockedPlot7560\FactionMaster\Utils\Ids;
use Zwuiix\AdvancedRank\player\RankPlayer;

/*
 *  A big thank you to @Ayzrix for this, I just modify them my way :p
 */
class FactionMaster
{
    /**
     * @param RankPlayer $player
     * @return string
     */
    public static function getPlayerFaction(RankPlayer $player): string
    {
        $faction = MainAPI::getFactionOfPlayer($player->getInitialPlayer()->getName());
        if($faction instanceof FactionEntity) return $faction->getName();
        return "...";
    }

    /**
     * @param RankPlayer $player
     * @return string
     */
    public static function getPlayerRank(RankPlayer $player): string
    {
        $user = MainAPI::getUser($player->getInitialPlayer()->getName());
        if ($user instanceof UserEntity) {
            return match ($user->rank) {
                Ids::MEMBER_ID => "*",
                Ids::COOWNER_ID => "**",
                Ids::OWNER_ID => "***",
                default => "",
            };
        }
        return "";
    }

    /**
     * @param RankPlayer $player
     * @return float|string
     */
    public static function getFactionPower(RankPlayer $player): float|string
    {
        $faction = MainAPI::getFactionOfPlayer($player->getInitialPlayer()->getName());
        if ($faction instanceof FactionEntity) return $faction->power;
        return 0;
    }

    /**
     * @param RankPlayer $player
     * @return float|string
     */
    public static function getFactionLevel(RankPlayer $player): float|string
    {
        $faction = MainAPI::getFactionOfPlayer($player->getInitialPlayer()->getName());
        if ($faction instanceof FactionEntity) return $faction->level;
        return 0;
    }

    /**
     * @param RankPlayer $player
     * @return float|string
     */
    public static function getFactionXP(RankPlayer $player): float|string
    {
        $faction = MainAPI::getFactionOfPlayer($player->getInitialPlayer()->getName());
        if ($faction instanceof FactionEntity) return $faction->xp;
        return 0;
    }

    /**
     * @param RankPlayer $player
     * @return float|string
     */
    public static function getFactionMessage(RankPlayer $player): float|string
    {
        $faction = MainAPI::getFactionOfPlayer($player->getInitialPlayer()->getName());
        $messageFaction = $faction?->messageFaction;
        if(!is_null($faction))return $faction->messageFaction;
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
            "{FAC_LEVEL}" => self::getFactionLevel($player),
            "{FAC_XP}" => self::getFactionXP($player),
            "{FAC_MESSAGE}" => self::getFactionMessage($player),
        ];
        return str_replace(array_keys($replace), array_values($replace), $message);
    }
}