<?php

namespace Zwuiix\AdvancedDiscord\listeners;

use JaxkDev\DiscordBot\Models\Activity;
use JaxkDev\DiscordBot\Models\Member;
use JsonException;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Zwuiix\AdvancedDiscord\data\sub\PluginData;
use Zwuiix\AdvancedDiscord\player\DiscordManager;
use Zwuiix\AdvancedDiscord\utils\Bot;

class EventListener implements Listener
{
    /**
     * @param PlayerJoinEvent $event
     * @return void
     * @throws JsonException
     */
    public function onJoin(PlayerJoinEvent $event): void
    {
        $player=$event->getPlayer();
        $dPlayer = DiscordManager::getInstance()->getPlayer($player);
        if(!$dPlayer->hasLogged()){
            $player->sendMessage(Bot::PREFIX."§cMerci de vous enregistrer sur notre serveur discord, veuillez effectuer la commande §e?verify §6{$player->getName()}");
            $player->setInvisible();
            foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
                $onlinePlayer->hidePlayer($player);
                $player->hidePlayer($onlinePlayer);
            }
        }
        $dPlayer->initialiseDiscordRole();
    }

    /**
     * @param PlayerMoveEvent $event
     * @return void
     */
    public function onMove(PlayerMoveEvent $event): void
    {
        $player=$event->getPlayer();
        $dPlayer = DiscordManager::getInstance()->getPlayer($player);
        if(!$dPlayer->hasLogged()){
            $dPlayer->getInitialPlayer()->setInvisible();
            $event->cancel();
            return;
        }
    }

    public function onChat(PlayerChatEvent $event)
    {
        $player=$event->getPlayer();
        $dPlayer = DiscordManager::getInstance()->getPlayer($player);
        if(!$dPlayer->hasLogged()){
            $player->sendMessage(Bot::PREFIX."§cDésolée, vous n'êtes pas enregistré, veuillez le faire!");
            $event->cancel();
            return;
        }
    }

    /**
     * @param EntityDamageEvent $event
     * @return void
     */
    public function onDamage(EntityDamageEvent $event): void
    {
        $entity=$event->getEntity();
        if(!$entity instanceof Player)return;
        $dPlayer = DiscordManager::getInstance()->getPlayer($entity);
        if(!$dPlayer->hasLogged()){
            $event->cancel();
            return;
        }
    }
}