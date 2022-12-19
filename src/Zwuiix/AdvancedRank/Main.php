<?php

namespace Zwuiix\AdvancedRank;

use JsonException;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\HookAlreadyRegistered;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\PacketHooker;
use Zwuiix\AdvancedRank\trait\LoaderTrait;
use Zwuiix\AdvancedRank\trait\ProviderTrait;

class Main extends PluginBase
{
    use SingletonTrait, LoaderTrait, ProviderTrait;

    /**
     * @throws HookAlreadyRegistered
     * @throws JsonException
     */
    protected function onEnable(): void
    {
        if(!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
        $this->init();
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

}