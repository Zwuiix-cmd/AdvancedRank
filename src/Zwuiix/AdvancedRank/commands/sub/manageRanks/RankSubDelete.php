<?php

namespace Zwuiix\AdvancedRank\commands\sub\manageRanks;

use pocketmine\player\Player;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\RawStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\ArgumentOrderException;
use Zwuiix\AdvancedRank\utils\Message;

class RankSubDelete extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("delete", "Delete a rank", []);
    }

    /**
     * @return void
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->setPermission("advancedrank.rank.delete");
    }

    /**
     * @param Player $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onNormalRun(Player $sender, string $aliasUsed, array $args): void
    {
        RankHandlers::getInstance()->deleteRank($args["name"]);
        Message::getInstance()->send($sender, null, "delete", $args["name"]);
    }
}