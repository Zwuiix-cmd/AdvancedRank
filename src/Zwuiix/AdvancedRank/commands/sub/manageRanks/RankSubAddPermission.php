<?php

namespace Zwuiix\AdvancedRank\commands\sub\manageRanks;

use JsonException;
use pocketmine\player\Player;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\RawStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\ArgumentOrderException;
use Zwuiix\AdvancedRank\rank\Rank;
use Zwuiix\AdvancedRank\utils\Message;

class RankSubAddPermission extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("addpermission", "Add a permission in rank", []);
    }

    /**
     * @return void
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->registerArgument(1, new RawStringArgument("permission"));
        $this->setPermission("rank.addpermission");
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
        if(RankHandlers::getInstance()->existPermission($rank, $args["permission"])){
            Message::getInstance()->send($sender, null, "exist-permission", "{$args["permission"]} ({$args["name"]})");
            return;
        }
        RankHandlers::getInstance()->addPermission($rank, $args["permission"]);
        Message::getInstance()->send($sender, null, "addpermission", "{$args["permission"]} ({$args["name"]})");
    }
}