<?php

namespace Zwuiix\AdvancedRank\data\sub;

use JsonException;
use Zwuiix\AdvancedRank\config\Config;
use Zwuiix\AdvancedRank\Main;

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