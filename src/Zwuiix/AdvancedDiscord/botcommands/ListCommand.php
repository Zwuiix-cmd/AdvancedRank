<?php

namespace Zwuiix\AdvancedDiscord\botcommands;

use JaxkDev\DiscordBot\Models\Messages\Embed\Embed;
use JaxkDev\DiscordBot\Models\Messages\Message;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use Zwuiix\AdvancedDiscord\botcommands\type\LoggedCommand;
use Zwuiix\AdvancedDiscord\utils\Bot;
use Zwuiix\AdvancedRank\extensions\AdvancedRankExtension;

class ListCommand extends LoggedCommand
{
    /**
     * @param string $sender
     * @param array $args
     * @param Message $message
     * @return void
     */
    public function onLoggedRun(string $sender, array $args, Message $message): void
    {
        $players=[];
        $plugin=Server::getInstance()->getPluginManager()->getPlugin("AdvancedRank");
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
            if($plugin instanceof Plugin){
                $rank = AdvancedRankExtension::getInstance()->getPlayerRank($onlinePlayer);
                $players[]="{$rank} {$onlinePlayer->getName()}";
                continue;
            }
            $players[]=$onlinePlayer->getName();
        }
        $description=implode("**,** ", $players);
        Bot::getInstance()->sendEmbedMessage($message->getChannelId(), $sender, "Voici la liste des personnes connectées", Embed::TYPE_ARTICLE, $description, null, null, null, "Développer par Zwuiix#0001");
    }

    public function prepare(): void
    {
        // TODO: Implement prepare() method.
    }
}