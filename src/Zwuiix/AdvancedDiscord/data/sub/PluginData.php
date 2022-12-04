<?php

namespace Zwuiix\AdvancedDiscord\data\sub;

use JsonException;
use Zwuiix\AdvancedDiscord\config\Config;
use Zwuiix\AdvancedDiscord\Main;

class PluginData
{
    /** @var Config */
    private static Config $data;

    /**
     * @throws JsonException
     */
    public function __construct(Main $main)
    {
        self::$data = new Config($main->getDataFolder()."/config.yml", Config::YAML);
    }

    public static function get(): ?Config
    {
        return self::$data;
    }
}