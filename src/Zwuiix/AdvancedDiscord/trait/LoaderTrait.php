<?php

namespace Zwuiix\AdvancedDiscord\trait;

use JsonException;
use Zwuiix\AdvancedDiscord\botcommands\ExecuteCommand;
use Zwuiix\AdvancedDiscord\botcommands\HelpCommand;
use Zwuiix\AdvancedDiscord\botcommands\InfoCommand;
use Zwuiix\AdvancedDiscord\botcommands\ListCommand;
use Zwuiix\AdvancedDiscord\botcommands\VerifyCommand;
use Zwuiix\AdvancedDiscord\config\Config;
use Zwuiix\AdvancedDiscord\commands\RankCommand;
use Zwuiix\AdvancedDiscord\data\Data;
use Zwuiix\AdvancedDiscord\extensions\Extensions;
use Zwuiix\AdvancedDiscord\handlers\CommandHandlers;
use Zwuiix\AdvancedDiscord\handlers\RankHandlers;
use Zwuiix\AdvancedDiscord\listeners\BotEventListener;
use Zwuiix\AdvancedDiscord\listeners\EventListener;
use Zwuiix\AdvancedDiscord\listeners\PlayerChat;
use Zwuiix\AdvancedDiscord\listeners\PlayerJoin;
use Zwuiix\AdvancedDiscord\listeners\PlayerQuit;
use Zwuiix\AdvancedDiscord\Main;
use Zwuiix\AdvancedDiscord\rank\Rank;
use Zwuiix\AdvancedDiscord\tasks\ActivityTask;
use Zwuiix\AdvancedDiscord\utils\Bot;
use Zwuiix\AdvancedDiscord\utils\PathScanner;

trait LoaderTrait
{
    protected Config $config;

    /**
     * @return void
     * @throws JsonException
     */
    public function init(): void
    {
        @mkdir($this->getDataFolder()."/database/");
        $this->saveResource("config.yml");

        $this->config=new Config($this->getDataFolder()."/config.yml", Config::YAML);
        $this->saveResource("/database/players.json");

        new Data($this);
        new Bot();

        $eventlist=[
            new BotEventListener(),
            new EventListener(),
        ];
        foreach ($eventlist as $value){
            $this->getServer()->getPluginManager()->registerEvents($value, $this);
        }
    }

    /**
     * @return Config|null
     */
    public function getData(): ?Config
    {
        return $this->config;
    }

    /**
     * @param string $message
     * @return void
     */
    public function notice(string $message): void
    {
        Main::getInstance()->getServer()->getLogger()->notice($message);
    }
}
