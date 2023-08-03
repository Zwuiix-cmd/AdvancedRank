<?php

namespace Zwuiix\AdvancedRank\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use Zwuiix\AdvancedRank\player\RankManager;

class PlayerChat implements Listener
{

    /**
     * @priority HIGHEST
     * @param PlayerChatEvent $event
     * @return void
     */
    public function onChat(PlayerChatEvent $event): void
    {
        $player=$event->getPlayer();
        $user=RankManager::getInstance()->getPlayer($player);
        $rank=$user->getRank();
        if($event->isCancelled())return;
        $event->setFormatter($user->getChatFormatter());
    }
}