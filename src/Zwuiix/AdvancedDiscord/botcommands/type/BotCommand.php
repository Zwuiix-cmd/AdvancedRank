<?php

namespace Zwuiix\AdvancedDiscord\botcommands\type;

use JaxkDev\DiscordBot\Models\Messages\Message;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

abstract class BotCommand
{
    /** @param string $name */
    public function __construct(protected string $name, protected string $description) {}

    /**
     * @param string $sender
     * @param array $args
     * @param Message $message
     * @return void
     */
    abstract public function onRun(string $sender, array $args, Message $message): void;

    abstract public function prepare(): void;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}