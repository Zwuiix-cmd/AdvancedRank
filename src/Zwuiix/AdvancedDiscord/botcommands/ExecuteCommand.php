<?php

namespace Zwuiix\AdvancedDiscord\botcommands;

use JaxkDev\DiscordBot\Models\Messages\Message;
use pocketmine\player\Player;
use pocketmine\Server;
use Zwuiix\AdvancedDiscord\botcommands\type\LoggedCommand;
use Zwuiix\AdvancedDiscord\data\sub\PlayersData;
use Zwuiix\AdvancedDiscord\utils\Bot;

class ExecuteCommand extends LoggedCommand
{
    /**
     * @param string $sender
     * @param array $args
     * @param Message $message
     * @return void
     */
    public function onLoggedRun(string $sender, array $args, Message $message): void
    {
        if(is_null(PlayersData::get()->getNested("dscIDS.{$sender}")) or is_null(PlayersData::get()->getNested("players.".PlayersData::get()->getNested("dscIDS.{$sender}")))){
            Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Désolée, vous n'êtes pas enregistré!", null, null, $message->getServerId()));
            return;
        }
        $xuid=PlayersData::get()->getNested("dscIDS.{$sender}");
        $name="Unknown";
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
            if($onlinePlayer->getXuid() === $xuid){
                $name=$onlinePlayer->getName();
            }
        }

        $player=Server::getInstance()->getPlayerExact($name);
        if(!$player instanceof Player){
            Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Désolée, vous n'êtes pas connecter!", null, null, $message->getServerId()));
            return;
        }
        if(!isset($args[0])){
            Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Veuillez faire ?execute (command) (args [optionnel])!", null, null, $message->getServerId()));
            return;
        }


        $rArgs=$args;
        unset($rArgs[0]);
        $rArgs=implode(" ", $rArgs);

        Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Execution de la commande **".$args[0]." ".$rArgs."** en cours...", null, null, $message->getServerId()));

        $player->sendMessage(Bot::PREFIX."§aExecution de la commande §e{$args[0]} {$rArgs}§a en cours...");
        $player->chat("/{$args[0]} {$rArgs}");
    }

    public function prepare(): void
    {
        // TODO: Implement prepare() method.
    }
}