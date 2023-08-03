<?php

namespace Zwuiix\AdvancedRank\commands\sub\managePlayers;

use JsonException;
use pocketmine\player\Player;
use pocketmine\Server;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\RawStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\ArgumentOrderException;
use Zwuiix\AdvancedRank\player\RankManager;
use Zwuiix\AdvancedRank\utils\Message;

class RankSubUserAddPermission extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("adduserpermission", "Add a permission in a user", []);
    }

    /**
     * @return void
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->registerArgument(1, new RawStringArgument("permission"));
        $this->setPermission("rank.adduserpermission");
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
        $player=Server::getInstance()->getPlayerByPrefix($args["name"]);
        if(!$player instanceof Player){
            Message::getInstance()->send($sender, null, "not-connected");
            return;
        }
        $user=RankManager::getInstance()->getPlayer($player);
        $user->addPermission($args["permission"]);

        Message::getInstance()->send($player, $sender, "adduserpermission", "{$args["permission"]}");
    }
}