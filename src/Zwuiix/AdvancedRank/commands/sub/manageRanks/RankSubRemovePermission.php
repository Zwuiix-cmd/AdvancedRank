<?php

namespace Zwuiix\AdvancedRank\commands\sub\manageRanks;

use JsonException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\data\sub\PluginData;
use Zwuiix\AdvancedRank\extensions\AdvancedRankExtension;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\IntegerArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\RawStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\BaseSubCommand;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\ArgumentOrderException;
use Zwuiix\AdvancedRank\player\RankManager;
use Zwuiix\AdvancedRank\rank\Rank;
use Zwuiix\AdvancedRank\utils\Message;

class RankSubRemovePermission extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("removepermission", "Remove a permission in rank", []);
    }

    /**
     * @return void
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->registerArgument(1, new RawStringArgument("permission"));
        $this->setPermission("rank.removepermission");
    }

    /**
     * @param Player $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     * @throws JsonException
     */
    public function onNormalRun(Player $sender, string $aliasUsed, array $args): void
    {
        $rank=RankHandlers::getInstance()->getRankNameByName($args["name"]);
        if(!$rank instanceof Rank){
            Message::getInstance()->send($sender, null, "rank-not-exist");
            return;
        }
        if(!RankHandlers::getInstance()->existPermission($rank, $args["permission"])){
            Message::getInstance()->send($sender, null, "not-exist-permission", "{$args["permission"]} ({$args["name"]})");
            return;
        }
        RankHandlers::getInstance()->removePermission($rank, $args["permission"]);
        Message::getInstance()->send($sender, null, "removepermission", "{$args["permission"]} ({$args["name"]})");
    }
}