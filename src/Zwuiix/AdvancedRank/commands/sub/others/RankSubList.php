<?php

namespace Zwuiix\AdvancedRank\commands\sub\others;

use pocketmine\player\Player;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\utils\Message;

class RankSubList extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("list", "Please press the button below to confirm your action!", []);
    }

    /**
     * @return void
     */
    protected function prepare(): void
    {
        $this->setPermission("rank.list");
    }

    /**
     * @param Player $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onNormalRun(Player $sender, string $aliasUsed, array $args): void
    {
        Message::getInstance()->send($sender, null, "list");
    }
}