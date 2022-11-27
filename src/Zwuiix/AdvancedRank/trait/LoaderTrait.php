<?php

namespace Zwuiix\AdvancedRank\trait;

use JsonException;
use Zwuiix\AdvancedRank\config\Config;
use Zwuiix\AdvancedRank\commands\RankCommand;
use Zwuiix\AdvancedRank\data\Data;
use Zwuiix\AdvancedRank\extensions\Extensions;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\listeners\PlayerChat;
use Zwuiix\AdvancedRank\listeners\PlayerJoin;
use Zwuiix\AdvancedRank\listeners\PlayerQuit;
use Zwuiix\AdvancedRank\Main;
use Zwuiix\AdvancedRank\rank\Rank;
use Zwuiix\AdvancedRank\utils\PathScanner;

trait LoaderTrait
{
    protected Config $config;

    /**
     * @return void
     * @throws JsonException
     */
    public function init(): void
    {
        @mkdir($this->getDataFolder()."/lang");
        @mkdir($this->getDataFolder()."/rank");
        @mkdir($this->getDataFolder()."/database/");
        $this->saveResource("config.yml");
        //$this->initProviders();

        $this->config=new Config($this->getDataFolder()."/config.yml", Config::YAML);

        $this->saveResource("/lang/fr.ini");
        $this->saveResource("/rank/player.".$this->config->get("default-rank-type"));
        $this->saveResource("/database/players.json");

        new Data($this);
        new Extensions(true);

        $eventlist=[
            new PlayerJoin(),
            new PlayerChat(),
            new PlayerQuit(),
        ];
        foreach ($eventlist as $value){
            $this->getServer()->getPluginManager()->registerEvents($value, $this);
        }

        $total_config = PathScanner::scanDirectoryToConfig($this->getDataFolder()."/rank/", [$this->config->get("default-rank-type")], Config::DETECT);
        foreach ($total_config as $config){
            Data::getInstance()->add($config->get("name"), $config);
            $rank = new Rank($config->get("name"), $config->get("priority"), $config->get("permissions"), $config->get("chat-format"), $config->get("nametag-format"));
            RankHandlers::getInstance()->addRank($rank);
            $this->getLogger()->notice("[RANK] : {$rank->getName()} has been loader!");
        }

        $this->getServer()->getCommandMap()->register("rank", new RankCommand($this));
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
