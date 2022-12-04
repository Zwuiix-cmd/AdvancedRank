<?php

namespace Zwuiix\AdvancedDiscord\data;

use JsonException;
use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedDiscord\config\Config;
use Zwuiix\AdvancedDiscord\data\sub\PlayersData;
use Zwuiix\AdvancedDiscord\data\sub\PluginData;
use Zwuiix\AdvancedDiscord\Main;

class Data
{
    use SingletonTrait;

    private array $configs;
    /**
     * @throws JsonException
     */
    public function __construct(Main $main)
    {
        self::setInstance($this);
        new PluginData($main);
        new PlayersData($main);
    }

    /**
     * @param string $name
     * @return Config
     */
    public function get(string $name): Config
    {
        return $this->configs[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exist(string $name): bool
    {
        return isset($this->configs[$name]);
    }

    /**
     * @param string $name
     * @param Config $config
     * @return void
     */
    public function add(string $name, Config $config): void
    {
        if($this->exist($name)){
            return;
        }
        $this->configs[$name] = $config;
    }

    /**
     * @param string $name
     * @return void
     */
    public function remove(string $name): void
    {
        unset($this->configs[$name]);
    }
}