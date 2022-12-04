<?php

namespace Zwuiix\AdvancedDiscord\player;

use JaxkDev\DiscordBot\Models\Role;
use JsonException;
use pocketmine\command\PluginCommand;
use pocketmine\player\Player;
use Zwuiix\AdvancedDiscord\data\sub\PlayersData;
use Zwuiix\AdvancedDiscord\data\sub\PluginData;
use Zwuiix\AdvancedDiscord\utils\Bot;

class DiscordPlayer
{
    /** @var Player */
    protected Player $player;

    /**
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return Player
     */
    public function getInitialPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return string
     */
    public function getXuid(): string
    {
        return $this->player->getXuid();
    }

    /**
     * @return string|null
     */
    public function getDiscordID(): ?string
    {
        return PlayersData::get()->getNested("players.".$this->getXuid().".discordID");
    }

    /**
     * @param string $discordID
     * @return void
     * @throws JsonException
     */
    public function setDiscordID(string $discordID): void
    {
        $data = PlayersData::get();
        $data->setNested("players.".$this->getXuid().".discordID", $discordID);
        $data->save();
        $this->initialiseDiscordRole();
    }

    /**
     * @return bool
     */
    public function hasLogged(): bool
    {
        if(PlayersData::get()->getNested("players.".$this->getXuid()) != null){
            return true;
        }
        return false;
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function initialiseDiscordRole(): void
    {
        if(!$this->hasLogged())return;
        $data=PluginData::get();
        $role=$data->get("verified-role");
        if(is_null($role)){
            $role=new Role("Verified", 0, false, 0, false, $data->get("server-id"));
            Bot::getInstance()->getApi()->createRole($role);
            $data->set("verified-role", $role->getId());
            $data->save();
            $role=$data->get("verified-role");
        }
        Bot::getInstance()->getApi()->addRole(Bot::getInstance()->getServerID().".{$this->getDiscordID()}", $role);
        Bot::getInstance()->getApi()->updateNickname(Bot::getInstance()->getServerID().".{$this->getDiscordID()}", $this->getInitialPlayer()->getName());
    }
}