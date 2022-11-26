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

class RankSubCreate extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("create", "Create a rank", []);
    }

    /**
     * @return void
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->registerArgument(1, new IntegerArgument("priority"));
        $this->registerArgument(2, new RawStringArgument("permissions"));
        $this->registerArgument(3, new RawStringArgument("chat"));
        $this->registerArgument(4, new RawStringArgument("nametag"));
        $this->setPermission("rank.create");
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
        RankHandlers::getInstance()->createRank($args["name"], $args["priority"], $args["permissions"], $args["chat"], $args["nametag"]);
        Message::getInstance()->send($sender, null, "create", $args["name"]);
    }
}