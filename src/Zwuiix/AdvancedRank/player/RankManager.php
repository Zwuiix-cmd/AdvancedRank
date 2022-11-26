<?php

namespace Zwuiix\AdvancedRank\player;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class RankManager
{
    use SingletonTrait;
    /** @var RankPlayer[] */
    private array $players = array();

    public function __construct()
    {
        self::setInstance($this);
    }

    /**
     * @param Player $player
     * @return RankPlayer
     */
    public function getPlayer(Player $player): RankPlayer
    {
        return $this->players[$player->getName()] ?? self::addPlayer($player);
    }

    public function existPlayer(Player $player): bool
    {
        return isset($this->players[$player->getName()]);
    }


    /**
     * @param Player $player
     * @return RankPlayer
     */
    public  function addPlayer(Player $player): RankPlayer
    {
        return $this->players[$player->getName()] = new RankPlayer($player);
    }

    public function removePlayer(Player $player): void
    {
        if($this->existPlayer($player)) unset($this->players[$player->getName()]);
    }
}