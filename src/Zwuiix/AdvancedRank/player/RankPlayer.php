<?php

namespace Zwuiix\AdvancedRank\player;

use JsonException;
use pocketmine\player\Player;
use Zwuiix\AdvancedRank\data\Data;
use Zwuiix\AdvancedRank\data\sub\PlayersData;
use Zwuiix\AdvancedRank\data\sub\PluginData;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\listeners\custom\PlayerRankChangeEvent;
use Zwuiix\AdvancedRank\Main;
use Zwuiix\AdvancedRank\rank\Rank;
use Zwuiix\AdvancedRank\utils\Format;

class RankPlayer
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
     * @return array
     */
    public function getPermissions(): array
    {
        return PlayersData::get()->getNested($this->getXuid().".permissions");
    }

    /**
     * @param string $permission
     * @throws JsonException
     */
    public function addPermission(string $permission): void
    {
        $data = PlayersData::get();
        $permissions = $data->getNested($this->getXuid().".permissions");
        $permissions[] = $permission;
        $data->setNested($this->getXuid().".permissions", $permissions);
        $data->save();
    }

    /**
     * @param string $permission
     * @throws JsonException
     */
    public function removePermission(string $permission): void
    {
        $data = PlayersData::get();
        $permissions = $data->getNested($this->getXuid().".permissions");
        $perms=[];
        foreach ($permissions as $perm){
            if($perm !== $permission){
                $perms[]=$perm;
            }
        }
        $data->setNested($this->getXuid().".permissions", $perms);
        $data->save();
    }

    /**
     * @return Rank|null
     */
    public function getRank(): ?Rank
    {
        return RankHandlers::getInstance()->getRankNameByName($this->getRankName());
    }

    /**
     * @return bool
     */
    public function hasRank(): bool
    {
        if(PlayersData::get()->get($this->getXuid()) != null){
            return true;
        }
        return false;
    }

    /**
     * @return bool|mixed
     */
    public function getRankName(): mixed
    {
        return PlayersData::get()->getNested($this->getXuid().".rank", PluginData::get()->get("default-rank", "Player"));
    }

    /**
     * @param Rank $rank
     * @return void
     * @throws JsonException
     */
    public function setRank(Rank $rank): void
    {
        $event = new PlayerRankChangeEvent(Main::getInstance(), $this, $rank, $this->getRank());
        $event->call();

        $data = PlayersData::get();
        $data->setNested($this->getXuid().".rank", $rank->getName());
        $data->save();
        $this->initialise();

    }

    /**
     * @param int $temp
     * @return void
     * @throws JsonException
     */
    public function setTemp(mixed $temp): void
    {
        $temp = time() + (intval($temp) * 86400);
        $data = PlayersData::get();
        $data->setNested($this->getXuid().".temp", $temp);
        $data->save();
        $this->initialise();
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function removeTemp(): void
    {
        $data = PlayersData::get();
        $data->removeNested($this->getXuid().".temp");
        $data->save();
    }

    /**
     * @return bool
     */
    public function hasTempRank(): bool
    {
        $data = PlayersData::get();
        $temp = $data->getNested($this->getXuid().".temp");
        if(is_null($temp))return false;
        return true;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        $data = PlayersData::get();
        $temp = $data->getNested($this->getXuid().".temp");
        if($temp > time()) return false;
        return true;
    }

    /**
     * @return string|null
     */
    public function getTemps(): ?string
    {
        $data = PlayersData::get();
        $temp = $data->getNested($this->getXuid().".temp");
        if(is_null($temp)) return "none";

        $remainingTime = $temp - time();
        $day = floor($remainingTime / 86400);
        $hourSeconds = $remainingTime % 86400;
        $hour = floor($hourSeconds / 3600);
        $minuteSec = $hourSeconds % 3600;
        $minute = floor($minuteSec / 60);
        $remainingSec = $minuteSec % 60;
        $second = ceil($remainingSec);
        return "{$day}d, {$hour}h, {$minute}m, {$second}s";
    }

    /**
     * @return void
     */
    private function initialisePermission(): void
    {
        $rank=RankHandlers::getInstance()->getRankNameByName($this->getRankName());
        $user=$this->getInitialPlayer();
        $plugin=Main::getInstance();
        if($rank instanceof Rank)return;
        if(!is_array($rank->getPermissions())){
            Main::getInstance()->getServer()->getLogger()->warning("[RANK] : Permissions error of {$rank->getName()}");
            return;
        }
        foreach ($rank->getPermissions() as $permission){
            $attachment = $user->addAttachment($plugin);
            $attachment->setPermission($permission, true);
            $user->addAttachment($plugin, $permission);
        }
        foreach ($this->getPermissions() as $permission){
            $attachment = $user->addAttachment($plugin);
            $attachment->setPermission($permission, true);
            $user->addAttachment($plugin, $permission);
        }
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function initialise(): void
    {
        if(!$this->hasRank()){
            $this->setRank(RankHandlers::getInstance()->getRankNameByName(PluginData::get()->get("default-rank", "Player")));
        }
        if($this->hasTempRank() && $this->isExpired()){
            $this->removeTemp();
            $this->setRank(RankHandlers::getInstance()->getRankNameByName(PluginData::get()->get("default-rank", "Player")));
        }
        $this->initialisePermission();
        $this->updateNameTag();
    }

    /**
     * @return void
     */
    public function updateNameTag(): void
    {
        $user=$this->getInitialPlayer();
        $rank_name=$this->getRankName();
        $rank=RankHandlers::getInstance()->getRankNameByName($rank_name);
        Format::getInstance()->initialise($rank->getNameTag(), $user->getName());
    }
}