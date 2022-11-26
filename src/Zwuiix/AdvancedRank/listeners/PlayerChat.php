<?php

namespace Zwuiix\AdvancedRank\listeners;

use JsonException;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\form\Form;
use Zwuiix\AdvancedRank\player\RankManager;
use Zwuiix\AdvancedRank\utils\Format;

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
        $event->setFormat(Format::getInstance()->initialise($rank->getChat(), $player->getName(), $event->getMessage()));
    }
}