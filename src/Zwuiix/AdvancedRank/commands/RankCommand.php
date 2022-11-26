<?php

namespace Zwuiix\AdvancedRank\commands;

use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use Zwuiix\AdvancedRank\data\sub\PluginData;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\BaseCommand;
use Zwuiix\AdvancedRank\Main;
use Zwuiix\AdvancedRank\utils\PathScanner;

class RankCommand extends BaseCommand
{
    public function __construct(protected Plugin $plugin)
    {
        parent::__construct($plugin, "rank", "Manager rank in your server", ["group"]);
    }

    protected function prepare(): void
    {
        $optional = false;
        $main=str_replace("Main", "", $this->plugin->getDescription()->getMain());
        $path=Main::getInstance()->getServer()->getDataPath()."plugins/{$this->plugin->getName()}/src/{$main}/commands/sub/";
        $scan = PathScanner::scanDirectory($path, ["php"]);
        $i=0;
        foreach ($scan as $item){
            $exp2=explode("/sub/", $item);
            $replace=str_replace([".php", "/"], ["", "\\"], $exp2[1]);
            $name="{$main}commands\sub\\$replace";
            if(PluginData::get()->get("form") == "true"){
                $optional = true;
            }
            $this->registerSubCommand(new $name($optional));
            $i++;
        }
        $this->setPermission("advancedrank");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $this->sendUsage();
    }
}