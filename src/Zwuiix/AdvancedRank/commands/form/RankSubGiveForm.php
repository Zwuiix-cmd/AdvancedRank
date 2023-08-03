<?php

namespace Zwuiix\AdvancedRank\commands\form;

use JsonException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\ArrayStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\RawStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\ArgumentOrderException;
use Zwuiix\AdvancedRank\player\RankManager;
use Zwuiix\AdvancedRank\rank\Rank;
use Zwuiix\AdvancedRank\utils\Message;

class RankSubGiveForm extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("give", "Give a rank to player", []);
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new ArrayStringArgument("name"));
        $this->registerArgument(1, new RawStringArgument("rank"));
        $this->setPermission("rank.give");
    }

    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     * @throws JsonException
     */
    public function onNormalRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $player=Server::getInstance()->getPlayerByPrefix($args["name"]);
        if(!$player instanceof Player){
            Message::getInstance()->send($sender, null, "not-connected");
            return;
        }
        $rank=RankHandlers::getInstance()->getRankNameByName($args["rank"]);
        if(!$rank instanceof Rank){
            Message::getInstance()->send($player, null, "rank-not-exist");
            return;
        }

        $user=RankManager::getInstance()->getPlayer($player);
        $user->setRank($rank);

        Message::getInstance()->send($player, $sender, "give");
        Message::getInstance()->broadcast($player, "broadcast-give");
    }
}