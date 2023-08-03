<?php

namespace Zwuiix\AdvancedRank\player;

use pocketmine\lang\Translatable;
use pocketmine\player\chat\ChatFormatter as ChatFormatterPM;
use Zwuiix\AdvancedRank\utils\Format;

class ChatFormatter implements ChatFormatterPM
{

    public function __construct(
        protected RankPlayer $player
    )
    {
    }

    public function format(string $username, string $message): Translatable|string
    {
        return Format::getInstance()->initialise($this->player->getRank()->getChat(), $this->player->getInitialPlayer()->getName(), $message);
    }
}