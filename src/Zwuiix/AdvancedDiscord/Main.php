<?php

namespace Zwuiix\AdvancedDiscord;

use JsonException;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedDiscord\trait\LoaderTrait;

class Main extends PluginBase
{
    use SingletonTrait, LoaderTrait;

    /**
     * @throws JsonException
     */
    protected function onEnable(): void
    {
        $this->init();
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

}