<?php

namespace Zwuiix\AdvancedDiscord\player;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class DiscordManager
{
    use SingletonTrait;
    /** @var DiscordPlayer[] */
    private array $players = array();

    public function __construct()
    {
        self::setInstance($this);
    }

    /**
     * @param Player $player
     * @return DiscordPlayer
     */
    public function getPlayer(Player $player): DiscordPlayer
    {
        return $this->players[$player->getName()] ?? self::addPlayer($player);
    }

    public function existPlayer(Player $player): bool
    {
        return isset($this->players[$player->getName()]);
    }


    /**
     * @param Player $player
     * @return DiscordPlayer
     */
    public  function addPlayer(Player $player): DiscordPlayer
    {
        return $this->players[$player->getName()] = new DiscordPlayer($player);
    }

    public function removePlayer(Player $player): void
    {
        if($this->existPlayer($player)) unset($this->players[$player->getName()]);
    }
}