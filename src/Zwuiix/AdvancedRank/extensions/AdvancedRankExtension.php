<?php

namespace Zwuiix\AdvancedRank\extensions;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\player\RankManager;
use Zwuiix\AdvancedRank\rank\Rank;

abstract class AdvancedRankExtension
{
    use SingletonTrait;

    /**
     * @return void
     */
    public function updateAllNameTag(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
            $user= RankManager::getInstance()->getPlayer($onlinePlayer);
            $user->updateNameTag();
        }
    }

    /**
     * @param string $name
     * @return Rank|null
     */
    public function getRank(string $name): ?Rank
    {
        return RankHandlers::getInstance()->getRankNameByName($name);
    }

    /**
     * @param Player $player
     * @return Rank|null
     */
    public function getPlayerRank(Player $player): ?Rank
    {
       $user=RankManager::getInstance()->getPlayer($player);
       return $user->getRankName();
    }

    /**
     * @return array
     */
    public function getAllRanks(): array
    {
        return RankHandlers::getInstance()->getAllRanks();
    }

    /**
     * @param Rank $rank
     * @return array
     */
    public function getPlayersByRank(Rank $rank): array
    {
        $players=[];
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
            $user= RankManager::getInstance()->getPlayer($onlinePlayer);
            if($user->getRankName() == $rank->getName()){
                $players[] = $user->getInitialPlayer()->getName();
            }
        }
        return $players;
    }
}