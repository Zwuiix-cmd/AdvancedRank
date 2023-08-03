<?php

namespace Zwuiix\AdvancedRank\commands\sub\manageRanks;

use pocketmine\player\Player;
use Zwuiix\AdvancedRank\commands\RankSubCommand;
use Zwuiix\AdvancedRank\data\sub\PluginData;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\interface\ManageForm;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\args\RawStringArgument;
use Zwuiix\AdvancedRank\lib\CortexPE\Commando\exception\ArgumentOrderException;
use Zwuiix\AdvancedRank\rank\Rank;
use Zwuiix\AdvancedRank\utils\Message;

class Manage extends RankSubCommand
{
    public function __construct()
    {
        parent::__construct("manage", "Manage a rank.", []);
    }

    /**
     * @return void
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->setPermission("rank.manage");
    }

    /**
     * @param Player $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onNormalRun(Player $sender, string $aliasUsed, array $args): void
    {
        if(PluginData::get()->get("form") !== "true"){
            Message::getInstance()->send($sender, null, "form-not-enabled");
            return;
        }
        $rank=RankHandlers::getInstance()->getRankNameByName($args["name"]);
        if(!$rank instanceof Rank){
            Message::getInstance()->send($sender, null, "rank-not-exist");
            return;
        }
        ManageForm::getInstance()->create($sender, $rank);
    }
}