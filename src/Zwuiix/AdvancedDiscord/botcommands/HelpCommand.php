<?php

namespace Zwuiix\AdvancedDiscord\botcommands;

use JaxkDev\DiscordBot\Models\Messages\Message;
use Zwuiix\AdvancedDiscord\botcommands\type\LoggedCommand;
use Zwuiix\AdvancedDiscord\handlers\CommandHandlers;
use Zwuiix\AdvancedDiscord\utils\Bot;

class HelpCommand extends LoggedCommand
{
    /**
     * @param string $sender
     * @param array $args
     * @param Message $message
     * @return void
     */
    public function onLoggedRun(string $sender, array $args, Message $message): void
    {
        $commandList="<@$sender> => Voici la liste des commandes disponible:\n\n";

        foreach (CommandHandlers::getInstance()->all() as $command){
            if($command->getName() !== "help"){
                $commandList.=" **-** {$command->getName()} `".$command->getDescription()."`\n\n";
            }
        }

        $commandList.="Cordialement.";
        Bot::getInstance()->getApi()->sendMessage(new Message($message->getChannelId(), null, $commandList, null, null, $message->getServerId()));
    }

    public function prepare(): void
    {
        // TODO: Implement prepare() method.
    }
}