<?php

namespace Zwuiix\AdvancedDiscord\listeners;

use JaxkDev\DiscordBot\Models\Activity;
use JaxkDev\DiscordBot\Models\Member;
use JaxkDev\DiscordBot\Models\Messages\Message;
use JaxkDev\DiscordBot\Plugin\Api;
use JaxkDev\DiscordBot\Plugin\Events\DiscordReady;
use JaxkDev\DiscordBot\Plugin\Events\MemberLeft;
use JaxkDev\DiscordBot\Plugin\Events\MemberUpdated;
use JaxkDev\DiscordBot\Plugin\Events\MessageReactionAdd;
use JaxkDev\DiscordBot\Plugin\Events\MessageSent;
use JaxkDev\DiscordBot\Plugin\Main;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use Zwuiix\AdvancedDiscord\botcommands\ExecuteCommand;
use Zwuiix\AdvancedDiscord\botcommands\HelpCommand;
use Zwuiix\AdvancedDiscord\botcommands\InfoCommand;
use Zwuiix\AdvancedDiscord\botcommands\ListCommand;
use Zwuiix\AdvancedDiscord\botcommands\VerifyCommand;
use Zwuiix\AdvancedDiscord\data\sub\PlayersData;
use Zwuiix\AdvancedDiscord\data\sub\PluginData;
use Zwuiix\AdvancedDiscord\handlers\BotHandlers;
use Zwuiix\AdvancedDiscord\handlers\CommandHandlers;
use Zwuiix\AdvancedDiscord\listeners\event\DiscordCommandEvent;
use Zwuiix\AdvancedDiscord\player\DiscordManager;
use Zwuiix\AdvancedDiscord\tasks\ActivityTask;
use Zwuiix\AdvancedDiscord\utils\Bot;
use Zwuiix\AdvancedRank\extensions\AdvancedRankExtension;
use Zwuiix\AdvancedRank\handlers\RankHandlers;
use Zwuiix\AdvancedRank\player\RankManager;
use Zwuiix\Vanilla\lib\CortexPE\Commando\args\Vector3Argument;

class BotEventListener implements Listener
{
    protected bool $ready = false;

    public function onReady(DiscordReady $event)
    {
        \Zwuiix\AdvancedDiscord\Main::getInstance()->notice("[DISCORD] : Bot loaded successfully");
        $this->ready = true;

        CommandHandlers::getInstance()->registers([
            new VerifyCommand("verify", "Liée sont compte discord a sont compte Minecraft"),
            new ExecuteCommand("execute", "Executer des commandes en jeux via votre compte discord"),
            new InfoCommand("info", "Obtenir les informations concernant un joueur"),
            new ListCommand("list", "Obtenir la liste des personnes connectées"),
            new HelpCommand("help", "Commande d'aide"),
        ]);
        \Zwuiix\AdvancedDiscord\Main::getInstance()->getScheduler()->scheduleRepeatingTask(new ActivityTask(), 20*30);
    }

    public function onMessage(MessageSent $event)
    {
        $message=$event->getMessage();
        $author=$message->getAuthorId();

        if(PluginData::get()->get("server-id") !== $message->getServerId())return;
        if(str_starts_with($message->getContent(), "?")){
            $msg=explode(" ", $message->getContent());
            $msg=str_replace("?", "", $msg[0]);

            $args=explode(" ", $message->getContent());
            unset($args[0]);

            $event = new DiscordCommandEvent(\Zwuiix\AdvancedDiscord\Main::getInstance(), $msg, $message->getAuthorId(), $args, $message);
            $event->call();
        }
    }

    /**
     * @param MemberLeft $event
     * @return void
     * @throws \JsonException
     */
    public function onLeave(MemberLeft $event): void
    {
        $event=$event->getMember();
        $member=$event->getUserId();
        if(PluginData::get()->get("server-id") !== $event->getServerId())return;
        if(is_null(PlayersData::get()->getNested("dscIDS.{$member}"))){
            return;
        }
        $xuid=PlayersData::get()->getNested("dscIDS.{$member}");
        if(is_null(PlayersData::get()->getNested("players.{$xuid}"))){
            return;
        }

        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
            if($onlinePlayer->getXuid() === $xuid){
                $onlinePlayer->sendMessage(Bot::PREFIX."§cVous avez quitté le serveur discord par conséquent veuillez vous enregistrer s'il vous plaît!");
            }
        }

        PlayersData::get()->removeNested("players.{$xuid}");
        PlayersData::get()->removeNested("dscIDS.{$member}");
        PlayersData::get()->save();
    }

    /**
     * @param MemberUpdated $event
     * @return void
     * @throws \JsonException
     */
    public function onUpdate(MemberUpdated $event): void
    {
        $member=$event->getMember();
        $plugin=Server::getInstance()->getPluginManager()->getPlugin("AdvancedRank");
        if(!$plugin instanceof Plugin)return;
        if(PluginData::get()->get("server-id") !== $member->getServerId())return;
        foreach ($member->getRoles() as $value => $role){
            foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                $dPlayer = DiscordManager::getInstance()->getPlayer($onlinePlayer);
                if ($member->getUserId() === $dPlayer->getDiscordID()) {
                    $rPlayer=RankManager::getInstance()->getPlayer($onlinePlayer);
                    $rBoost=PluginData::get()->getNested("boost.rank");
                    if($rPlayer->getRankName() === $rBoost){
                        $rPlayer->setRank(RankHandlers::getInstance()->getRankNameByName(\Zwuiix\AdvancedRank\data\sub\PluginData::get()->get("default-rank", "Player")));
                        return;
                    }
                    if(PluginData::get()->getNested("boost.role-id") === $role) {
                        $rPlayer->setRank(RankHandlers::getInstance()->getRankNameByName($rBoost));
                    }
                    return;
                }
            }
        }
    }

    /**
     * @param DiscordCommandEvent $event
     * @return void
     * @throws \JsonException
     */
    public function onCommand(DiscordCommandEvent $event): void
    {
        $sender=$event->getSender();
        $args=$event->getArgs();
        $message=$event->getMessage();

        foreach (CommandHandlers::getInstance()->all() as $command){
            if($command->getName() === $event->getCommandName()){
                $command->onRun($sender, $args, $message);
                return;
            }
        }

        Bot::getInstance()->sendMessage($message->getChannelId(), $sender, "Désolée, cette commande est introuvable, éssayez la commande *help*!");
    }
}
