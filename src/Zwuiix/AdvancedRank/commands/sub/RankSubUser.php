<?php

namespace Zwuiix\AdvancedRank\commands\sub;

use pocketmine\player\Player;
use pocketmine\Server;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\RawStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\ArgumentOrderException;
use Zwuiix\AdvancedRank\utils\Message;

class RankSubUser extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("user", "Information of player", []);
    }

    /**
     * @return void
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->setPermission("advancedrank.rank.user");
    }

    /**
     * @param Player $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onNormalRun(Player $sender, string $aliasUsed, array $args): void
    {
        $player=Server::getInstance()->getPlayerByPrefix($args["name"]);
        if(!$player instanceof Player){
            Message::getInstance()->send($sender, null, "not-connected");
            return;
        }
        Message::getInstance()->send($player, $sender, "user-info");
    }
}