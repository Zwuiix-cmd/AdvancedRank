<?php

namespace Zwuiix\AdvancedDiscord\listeners\event;

use JaxkDev\DiscordBot\Models\Messages\Message;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\plugin\Plugin;

class DiscordCommandEvent extends PluginEvent
{
    /**
     * @param Plugin $plugin
     * @param string $commandName
     * @param string $sender
     * @param array $args
     * @param Message $message
     */
    public function __construct(Plugin $plugin, protected string $commandName, protected string $sender, protected array $args, protected Message $message){
        parent::__construct($plugin);
    }

    /**
     * @return string
     */
    public function getCommandName(): string
    {
        return $this->commandName;
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        $args=explode(".", $this->sender);
        return $args[1];
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        $args=$this->args;
        $nArgs=[];
        foreach ($args as $arg => $value){
            $nArgs[]=$value;
        }
        return $nArgs;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }
}