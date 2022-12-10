<?php

namespace Zwuiix\AdvancedRank\handlers;

use JsonException;
use pocketmine\command\PluginCommand;
use pocketmine\entity\projectile\Throwable;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedRank\data\Data;
use Zwuiix\AdvancedRank\data\sub\PluginData;
use Zwuiix\AdvancedRank\Main;
use Zwuiix\AdvancedRank\player\RankManager;
use Zwuiix\AdvancedRank\rank\Rank;

class RankHandlers
{
    use SingletonTrait;

    /** @var Rank[] */
    protected array $ranks = array();

    /**
     * @return array
     */
    public function getAllRanks(): array
    {
        return $this->ranks;
    }

    public function getRankNameByName(string $name): ?Rank
    {
        if($this->existRank($name)){
            return $this->ranks[$name];
        }
        return null;
    }

    public function existRank(string $name): bool
    {
        return isset($this->ranks[$name]);
    }

    /**
     * @param Rank $rank
     * @return void
     */
    public function removeRank(Rank $rank): void
    {
        if(!$this->existRank($rank->getName())){
            Main::getInstance()->getServer()->getLogger()->warning("[RANK] : Rank not delete due no exist");
            return;
        }
        unset($this->ranks[$rank->getName()]);
        Main::getInstance()->notice("[RANK] : Rank {$rank->getName()} deleted!");
    }

    /**
     * @param Rank $rank
     * @return void
     */
    public function addRank(Rank $rank): void
    {
        if($this->existRank($rank->getName())){
            Main::getInstance()->getServer()->getLogger()->warning("[RANK] : Rank not added due to duplicate name");
            return;
        }

        $this->ranks[$rank->getName()] = $rank;
    }

    public function existPermission(Rank $rank, string $permission): bool
    {
        $data = Data::getInstance()->get($rank->getName());
        $permissions = $data->get("permissions");
        var_dump($permissions);
        if(array_search($permission, $permissions)) return true;
        return false;
    }

    /**
     * @param Rank $rank
     * @param string $permission
     * @return void
     * @throws JsonException
     */
    public function addPermission(Rank $rank, string $permission): void
    {
        $rank->addPermission($permission);
        $data = Data::getInstance()->get($rank->getName());
        $permissions = $data->get("permissions");
        $permissions[] = $permission;
        $data->set("permissions", $permissions);
        $data->save();
    }

    /**
     * @param Rank $rank
     * @param string $permission
     * @return void
     * @throws JsonException
     */
    public function removePermission(Rank $rank, string $permission): void
    {
        $rank->removePermission($permission);
        $data = Data::getInstance()->get($rank->getName());
        $permissions = $data->get("permissions");
        $perms=[];
        foreach ($permissions as $perm){
            if($perm !== $permission){
                $perms[]=$perm;
            }
        }
        $data->set("permissions", $perms);
        $data->save();
    }

    /**
     * @param string $name
     * @param int $priority
     * @param string $permissions
     * @param string $chat
     * @param string $nameTag
     * @return void
     * @throws JsonException
     */
    public function createRank(string $name, int $priority, string $permissions, string $chat, string $nameTag): void
    {
        if($this->existRank($name)){
            Main::getInstance()->getServer()->getLogger()->warning("[RANK] : Rank not added due to duplicate name");
            return;
        }
        $config = new Config(Main::getInstance()->getDataFolder()."/rank/".strtolower($name) . "." .PluginData::get()->get("default-rank-type"), Config::DETECT);
        $config->set("name", $name);
        $config->set("priority", $priority);
        $config->set("permissions", [$permissions]);
        $config->set("chat-format", $chat);
        $config->set("nametag-format", $nameTag);
        $config->save();

        $rank = new Rank($config->get("name"), $config->get("priority"), $config->get("permissions"), $config->get("chat-format"), $config->get("nametag-format"));
        $this->addRank($rank);
        Main::getInstance()->notice("[RANK] : {$rank->getName()} has been loader!");
    }

    public function deleteRank(string $name): void
    {
        if(!$this->existRank($name)){
            Main::getInstance()->getServer()->getLogger()->warning("[RANK] : Rank not delete due no exist");
            return;
        }
        $rank=$this->getRankNameByName($name);
        Main::getInstance()->notice("[RANK] : {$rank->getName()} has been unloader!");
        $this->removeRank($rank);
        unlink(Main::getInstance()->getDataFolder()."/rank/{$rank->getName()}." . PluginData::get()->get("default-rank-type"));
        rmdir(Main::getInstance()->getDataFolder()."/rank/{$rank->getName()}." . PluginData::get()->get("default-rank-type"));
    }

    /**
     * @param Rank $rank
     * @return array
     */
    public function getPlayersByRank(Rank $rank): array
    {
        $players=[];
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
            $user=RankManager::getInstance()->getPlayer($onlinePlayer);
            if($user->getRankName() == $rank->getName()){
                $players[] = $user->getInitialPlayer()->getName();
            }
        }
        return $players;
    }

    /**
     * @return string
     */
    public function getRanksList(): string
    {
        $rank_name=[];
        foreach ($this->ranks as $rank => $value){
            $rank_name[] = $rank;
        }
        return implode("§f, §e", $rank_name);
    }
}