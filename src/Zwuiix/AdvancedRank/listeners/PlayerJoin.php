<?php

namespace Zwuiix\AdvancedRank\listeners;

use JsonException;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Zwuiix\AdvancedRank\player\RankManager;

class PlayerJoin implements Listener
{
    /**
     * @priority HIGHEST
     * @param PlayerJoinEvent $event
     * @return void
     * @throws JsonException
     */
    public function onJoin(PlayerJoinEvent $event): void
    {
        $player=$event->getPlayer();
        $user=RankManager::getInstance()->getPlayer($player);
        $user->initialise();
    }
}