<?php

namespace Zwuiix\AdvancedRank\commands;

use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use Zwuiix\AdvancedRank\commands\sub\managePlayers\RankSubGive;
use Zwuiix\AdvancedRank\commands\sub\managePlayers\RankSubSet;
use Zwuiix\AdvancedRank\commands\sub\managePlayers\RankSubTempGive;
use Zwuiix\AdvancedRank\commands\sub\managePlayers\RankSubUserAddPermission;
use Zwuiix\AdvancedRank\commands\sub\managePlayers\RankSubUserRemovePermission;
use Zwuiix\AdvancedRank\commands\sub\manageRanks\Manage;
use Zwuiix\AdvancedRank\commands\sub\manageRanks\RankSubAddPermission;
use Zwuiix\AdvancedRank\commands\sub\manageRanks\RankSubCreate;
use Zwuiix\AdvancedRank\commands\sub\manageRanks\RankSubDelete;
use Zwuiix\AdvancedRank\commands\sub\manageRanks\RankSubInfo;
use Zwuiix\AdvancedRank\commands\sub\manageRanks\RankSubRemovePermission;
use Zwuiix\AdvancedRank\commands\sub\others\RankSubList;
use Zwuiix\AdvancedRank\commands\sub\RankSubUser;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\BaseCommand;

class RankCommand extends BaseCommand
{
    public function __construct(protected Plugin $plugin)
    {
        parent::__construct($plugin, "rank", "Manager rank in your server", ["group"]);
    }

    protected function prepare(): void
    {
        $optional = false;
        /*
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
        */

        $this->registerSubCommand(new RankSubGive());
        $this->registerSubCommand(new RankSubSet());
        $this->registerSubCommand(new RankSubTempGive());
        $this->registerSubCommand(new RankSubUserAddPermission());
        $this->registerSubCommand(new RankSubUserRemovePermission());
        $this->registerSubCommand(new Manage());
        $this->registerSubCommand(new RankSubAddPermission());
        $this->registerSubCommand(new RankSubCreate());
        $this->registerSubCommand(new RankSubDelete());
        $this->registerSubCommand(new RankSubInfo());
        $this->registerSubCommand(new RankSubRemovePermission());
        $this->registerSubCommand(new RankSubList());
        $this->registerSubCommand(new RankSubUser());
        $this->setPermission("advancedrank");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $this->sendUsage();
    }
}