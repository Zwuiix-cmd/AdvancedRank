<?php

namespace Zwuiix\AdvancedRank\listeners\custom;

use JaxkDev\DiscordBot\Models\Messages\Message;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use Zwuiix\AdvancedRank\player\RankPlayer;
use Zwuiix\AdvancedRank\rank\Rank;

class PlayerRankChangeEvent extends PluginEvent
{
    /**
     * @param Plugin $plugin
     * @param RankPlayer $player
     * @param Rank $rank
     */
    public function __construct(Plugin $plugin, protected RankPlayer $player, protected Rank $rank){
        parent::__construct($plugin);
    }

    /**
     * @return RankPlayer
     */
    public function getPlayer(): RankPlayer
    {
        return $this->player;
    }

    /**
     * @return Rank
     */
    public function getRank(): Rank
    {
        return $this->rank;
    }
}