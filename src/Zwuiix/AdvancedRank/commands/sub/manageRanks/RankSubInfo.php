<?php

namespace Zwuiix\AdvancedRank\commands\sub\manageRanks;

use pocketmine\player\Player;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\RawStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\ArgumentOrderException;
use Zwuiix\AdvancedRank\rank\Rank;
use Zwuiix\AdvancedRank\utils\Message;

class RankSubInfo extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("info", "Get the information about a rank!", []);
    }

    /**
     * @return void
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("rank"));
        $this->setPermission("rank.info");
    }

    /**
     * @param Player $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onNormalRun(Player $sender, string $aliasUsed, array $args): void
    {
        $rank=RankHandlers::getInstance()->getRankNameByName($args["rank"]);
        if(!$rank instanceof Rank){
            Message::getInstance()->send($sender, null, "rank-not-exist");
            return;
        }
        Message::getInstance()->send($sender, null, "info", "", $rank->getName());
        Message::getInstance()->send($sender, null, "priority", "", $rank->getName());
        Message::getInstance()->send($sender, null, "permissions", "", $rank->getName());
        Message::getInstance()->send($sender, null, "players", "", $rank->getName());
    }
}