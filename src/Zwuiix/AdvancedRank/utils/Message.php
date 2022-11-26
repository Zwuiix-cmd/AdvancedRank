<?php

namespace Zwuiix\AdvancedRank\utils;

use pocketmine\command\CommandSender;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use Zwuiix\AdvancedRank\data\sub\Langage;
use Zwuiix\AdvancedRank\data\sub\PluginData;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\player\RankPlayer;
use Zwuiix\AdvancedRank\rank\Rank;

class Message
{
    use SingletonTrait;
    
    /**
     * @param Player|ConsoleCommandSender|CommandSender $player
     * @param Player|ConsoleCommandSender|CommandSender|null $sender
     * @param string $message
     * @return void
     */
    public function send(Player|ConsoleCommandSender|CommandSender $player, Player|ConsoleCommandSender|CommandSender|null $sender, string $message, string $mS = "", $rank_name = ""): void
    {
        if($sender == null) $sender=$player;

        $data=PluginData::get();
        $lang=Langage::get();
        $prefix=Format::getInstance()->initialiseColor($lang->getNested("Information.prefix"));

        $msg = Format::getInstance()->initialise($lang->getNested("Rank.$message"), $player->getName());

        if($mS != ""){
            $msg = str_replace("{ARGS}", $mS, $msg);
        }
        if($rank_name != ""){
            $rank=RankHandlers::getInstance()->getRankNameByName($rank_name);
            if($rank instanceof Rank){
                $replace = [
                    "{RANK_NAME}" => $rank->getName(),
                    "{RANK_PRIORITY}" => $rank->getPriority(),
                    "{RANK_PERMISSIONS}" => implode("§f, §e", $rank->getPermissions()),
                    "{RANK_PLAYERS}" => implode("§f, §e", RankHandlers::getInstance()->getPlayersByRank($rank)),
                ];
                $msg = str_replace(array_keys($replace), array_values($replace), $msg);
            }
        }

        if($data->get("use-prefix") == "true"){
            $msg = $prefix.$msg;
        }

        $sender->sendMessage($msg);
    }

    /**
     * @param string $message
     * @return string|array
     */
    public function others(string $message): string|array
    {
        $data=PluginData::get();
        $lang=Langage::get();
        $prefix=Format::getInstance()->initialiseColor($lang->getNested("Information.prefix"));

        $msg = Format::getInstance()->initialise($lang->getNested("Rank.$message"), "null");

        if($data->get("use-prefix")){
            $msg = $prefix.$msg;
        }

        return $msg;
    }

    /**
     * @param Player $player
     * @param string $message
     * @return void
     */
    public function broadcast(Player $player, string $message): void
    {
        $data=PluginData::get();
        $lang=Langage::get();
        $prefix=Format::getInstance()->initialiseColor($lang->getNested("Information.prefix"));

        if(!$lang->existsNested("Rank.{$message}")){
            Server::getInstance()->broadcastMessage(TextFormat::RED."An error occurred in the configuration, please contact an administrator!");
            return;
        }

        $msg = Format::getInstance()->initialise($lang->getNested("Rank.$message"), $player->getName());

        if($data->get("use-prefix")){
            $msg = $prefix.$msg;
        }

        Server::getInstance()->broadcastMessage($msg);
    }
}