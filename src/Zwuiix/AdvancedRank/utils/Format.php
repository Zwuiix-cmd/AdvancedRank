<?php

namespace Zwuiix\AdvancedRank\utils;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use Zwuiix\AdvancedRank\extensions\Extensions;
use Zwuiix\AdvancedRank\extensions\lib\Base;
use Zwuiix\AdvancedRank\extensions\lib\EconomyAPI;
use Zwuiix\AdvancedRank\extensions\lib\FactionMaster;
use Zwuiix\AdvancedRank\extensions\lib\InfoTag;
use Zwuiix\AdvancedRank\extensions\lib\PiggyFactions;
use Zwuiix\AdvancedRank\extensions\lib\SimpleFaction;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\player\RankManager;
use Zwuiix\AdvancedRank\player\RankPlayer;

class Format
{
    use SingletonTrait;

    /**
     * @var array
     */
    private array $colorTag = [];
    public function __construct()
    {
        $this->initialiseTextFormatColor();
    }

    public function initialise(string $format, string $name, string $msg = ""): array|string
    {
        $message=$format;
        $rank="Unknown";

        $player=Server::getInstance()->getPlayerExact($name);
        if($player instanceof Player){
            $player=RankManager::getInstance()->getPlayer($player);
            $message = Base::replace($player, $message);
            $rank = $player->getRankName();
        }

        $fm = Format::getInstance()->initialiseColor($message);
        if(Extensions::isLoaded("EconomyAPI")){
            $fm = EconomyAPI::replace($player, $fm);
        }
        if(Extensions::isLoaded("PiggyFactions")){
            $fm = PiggyFactions::replace($player, $fm);
        }
        if(Extensions::isLoaded("SimpleFaction")){
            $fm = SimpleFaction::replace($player, $fm);
        }
        if(Extensions::isLoaded("FactionMaster")){
            $fm = FactionMaster::replace($player, $fm);
        }
        if(Extensions::isLoaded("InfoTag")){
            $fm = InfoTag::replace($player, $fm);
        }

        $replace = [
            "{RANK}" => $rank,
            "{MSG}" => $msg,
            "{RANKS_LIST}" => RankHandlers::getInstance()->getRanksList(),
        ];

        return str_replace(array_keys($replace), array_values($replace), $fm);
    }

    /**
     * @param string $format
     * @return array|string|string[]
     */
    public function initialiseColor(string $format): array|string
    {
       return str_replace(array_keys($this->getColorTag()), array_values($this->getColorTag()), $format);
    }

    /**
     * @return array
     */
    public function getColorTag(): array
    {
        return $this->colorTag;
    }

    private function initialiseTextFormatColor(): void
    {
        foreach ((new \ReflectionClass(TextFormat::class))->getConstants() as $color => $code) {
            if (is_string($code)) $this->colorTag["{" . mb_strtoupper($color) . "}"] = $code;
        }
    }
}