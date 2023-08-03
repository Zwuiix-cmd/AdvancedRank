<?php

namespace Zwuiix\AdvancedRank\extensions;

use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedRank\data\sub\PluginData;
use Zwuiix\AdvancedRank\Main;

class Extensions
{
    use SingletonTrait;

    /** @var array */
    public array $loaded = array();

    public function __construct(bool $allLoad = false)
    {
        self::setInstance($this);
        if($allLoad){
            $this->loadAll();
        }
    }

    /**
     * @return void
     */
    public function loadAll(): void
    {
        $config=PluginData::get();
        foreach ($config->get("extensions") as $extension => $value){
            if($value == "true"){
                $this->load($extension);
            }
        }
    }

    /**
     * @param string $extension
     * @return bool
     */
    public function load(string $extension): bool
    {
        $plugin=Server::getInstance()->getPluginManager()->getPlugin($extension);
        if(!$plugin instanceof Plugin){
            Main::getInstance()->getServer()->getLogger()->warning("[EXTENSIONS] : {$extension} not loaded!");
            return false;
        }
        Main::getInstance()->notice("[EXTENSIONS] : {$plugin->getName()} loaded!");
        $this->loaded[$plugin->getName()] = true;
        return true;
    }

    public static function isLoaded(string $name): bool
    {
        return isset(Extensions::getInstance()->loaded[$name]);
    }
}