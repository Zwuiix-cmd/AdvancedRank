<?php

namespace Zwuiix\AdvancedDiscord\data\sub;

use JsonException;
use Zwuiix\AdvancedDiscord\config\Config;
use Zwuiix\AdvancedDiscord\Main;

class PlayersData
{
    /** @var Config */
    private static Config $data;

    /**
     * @param Main $main
     * @throws JsonException
     */
    public function __construct(private Main $main)
    {
        self::$data = new Config($this->main->getDataFolder()."/database/players.json", Config::JSON);
    }

    public static function get(): ?Config
    {
        return self::$data;
    }
}