<?php

namespace Zwuiix\AdvancedRank\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use Zwuiix\AdvancedRank\player\RankManager;

class PlayerQuit implements Listener
{
    /**
     * @priority HIGHEST
     * @param PlayerQuitEvent $event
     * @return void
     */
    public function onQuit(PlayerQuitEvent $event): void
    {
        $player=$event->getPlayer();
        RankManager::getInstance()->removePlayer($player);
    }
}