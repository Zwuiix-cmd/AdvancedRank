<?php

namespace Zwuiix\AdvancedDiscord\handlers;

use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedDiscord\botcommands\type\BotCommand;
use Zwuiix\AdvancedDiscord\Main;

class CommandHandlers
{
    use SingletonTrait;

    /** @var BotCommand[] */
    private array $commands;

    /**
     * @param BotCommand $command
     * @return void
     */
    public function register(BotCommand $command): void
    {
        $this->commands[]=$command;
        Server::getInstance()->getLogger()->notice("[DISCORD] : Command {$command->getName()} loaded successfully");
    }

    /**
     * @param BotCommand[] $commands
     * @return void
     */
    public function registers(array $commands): void
    {
        foreach ($commands as $command){
            $this->register($command);
        }
    }

    /**
     * @return BotCommand[]
     */
    public function all(): array
    {
        return $this->commands;
    }
}