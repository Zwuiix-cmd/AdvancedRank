<?php

namespace Zwuiix\AdvancedDiscord\botcommands\type;

use JaxkDev\DiscordBot\Models\Messages\Message;
use Zwuiix\AdvancedDiscord\utils\Bot;

abstract class LoggedCommand extends BotCommand
{
    /**
     * @param string $sender
     * @param array $args
     * @param Message $message
     * @return void
     */
    public function onRun(string $sender, array $args, Message $message): void
    {
        if(!Bot::getInstance()->isLogged($message->getChannelId(), $sender))return;
        $this->onLoggedRun($sender, $args, $message);
    }

    /**
     * @param string $sender
     * @param array $args
     * @param Message $message
     * @return void
     */
    abstract public function onLoggedRun(string $sender, array $args, Message $message): void;
}