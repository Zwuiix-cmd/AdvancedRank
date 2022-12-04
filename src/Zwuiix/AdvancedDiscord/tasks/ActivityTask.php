<?php

namespace Zwuiix\AdvancedDiscord\tasks;

use JaxkDev\DiscordBot\Models\Activity;
use JaxkDev\DiscordBot\Models\Member;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use Zwuiix\AdvancedDiscord\utils\Bot;

class ActivityTask extends Task
{
    public function onRun(): void
    {
        $bot=Bot::getInstance()->getApi();
        $bot->updateBotPresence(new Activity(count(Server::getInstance()->getOnlinePlayers())." players", Activity::TYPE_LISTENING), Member::STATUS_DND);
    }
}