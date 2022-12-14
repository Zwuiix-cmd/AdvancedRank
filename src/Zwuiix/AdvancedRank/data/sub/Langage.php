<?php

namespace Zwuiix\AdvancedRank\data\sub;

use JsonException;
use Zwuiix\AdvancedRank\config\Config;
use Zwuiix\AdvancedRank\Main;
use Zwuiix\AdvancedRank\utils\PathScanner;

class Langage
{
    /** @var Config */
    private static Config $data;

    /**
     * @throws JsonException
     */
    public function __construct(Main $main)
    {
        $default_lang=PluginData::get()->get("langage");
        $dataFolder=$main->getDataFolder()."/lang/";

        $langs = PathScanner::scanDirectoryToConfig($dataFolder, ["ini"], Config::INI);
        $lang="null";
        foreach ($langs as $lg){
            if($lg->getNested("Information.lang") === $default_lang){
                $lang = $lg->getNested("Information.lang");
                break;
            }
        }

        Main::getInstance()->notice("[RANK] : Loading {$lang} lang...");
        self::$data = new Config($dataFolder."{$lang}.ini", Config::INI);
    }

    public static function get(): ?Config
    {
        return self::$data;
    }
}