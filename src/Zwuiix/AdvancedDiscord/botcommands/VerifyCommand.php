<?php

namespace Zwuiix\AdvancedDiscord\botcommands;

use JaxkDev\DiscordBot\Models\Messages\Message;
use JsonException;
use pocketmine\player\Player;
use pocketmine\Server;
use Zwuiix\AdvancedDiscord\botcommands\type\BotCommand;
use Zwuiix\AdvancedDiscord\data\sub\PlayersData;
use Zwuiix\AdvancedDiscord\player\DiscordManager;
use Zwuiix\AdvancedDiscord\utils\Bot;

class VerifyCommand extends BotCommand
{
    /**
     * @param string $sender
     * @param array $args
     * @param Message $message
     * @return void
     * @throws JsonException
     */
    public function onRun(string $sender, array $args, Message $message): void
    {
        if(!isset($args[0])){
            Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Veuillez faire ?verify (votre pseudo)!", null, null, $message->getServerId()));
            return;
        }
        $player=Server::getInstance()->getPlayerExact($args[0]);
        if(!$player instanceof Player){
            Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Désolée, le pseudo que vous avez saisie n'est pas connecter!", null, null, $message->getServerId()));
            return;
        }
        $dPlayer=DiscordManager::getInstance()->getPlayer($player);
        if($dPlayer->hasLogged()){
            Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Désolée, ce joueur est déjà enregistré sous un autre compte!", null, null, $message->getServerId()));
            return;
        }
        if(!is_null(PlayersData::get()->getNested("dscIDS.{$sender}"))){
            Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Désolée, vous êtes déjà enregistré sous un autre compte!", null, null, $message->getServerId()));
            return;
        }
        PlayersData::get()->setNested("dscIDS.{$sender}", $player->getXuid());
        PlayersData::get()->save();
        $dPlayer->setDiscordID($sender);
        Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, "<@$sender> => Vous avez été enregistré sous ".$player->getName()." avec succès!", null, null, $message->getServerId()));
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
            $onlinePlayer->showPlayer($player);
            $player->showPlayer($onlinePlayer);
        }
        $player->setInvisible(false);
        $player->sendMessage(Bot::PREFIX."§aVous avez été enregistré avec succès!");
    }

    public function prepare(): void
    {
        // TODO: Implement prepare() method.
    }
}