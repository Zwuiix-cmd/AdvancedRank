<?php

namespace Zwuiix\AdvancedRank\data\sub;

use JsonException;
use Zwuiix\AdvancedRank\config\Config;
use Zwuiix\AdvancedRank\Main;

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