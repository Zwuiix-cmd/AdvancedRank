<?php

namespace Zwuiix\AdvancedRank\trait;

use JsonException;
use Zwuiix\AdvancedRank\config\Config;
use SQLite3;
use Zwuiix\AdvancedRank\Main;

trait ProviderTrait
{
    use LoaderTrait;
    /**
     * @var Config[]|SQLite3[]
     */
    private array $providers = [];

    /**
     * @param string $name
     * @return SQLite3|Config
     */
    public function getProvider(string $name): SQLite3|Config
    {
        return $this->providers[strtolower($name)];
    }

    /**
     * @param string $name
     * @param object $provider
     * @return void
     */
    public function addProvider(string $name,object $provider): void
    {
        $Sname = strtolower($name);
        if(!isset($this->providers[$Sname]))
        {
            $this->providers[$Sname] = $provider;
            $this->notice("[PROVIDERS] : Adding new provider $name");
        }else
        {
            throw new \LogicException("$name is already defined as a provider !");
        }
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function initProviders(): void
    {
        $dataFolder = Main::getInstance()->getDataFolder();
        $this->addProvider("config", new Config($dataFolder . "/config.yml", Config::YAML));
        $this->addProvider("database", new Config($dataFolder . "/database/players.json", Config::JSON));
    }
}