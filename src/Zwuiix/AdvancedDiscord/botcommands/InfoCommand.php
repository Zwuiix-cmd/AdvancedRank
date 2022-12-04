<?php

namespace Zwuiix\AdvancedDiscord\botcommands;

use JaxkDev\DiscordBot\Models\Messages\Embed\Embed;
use JaxkDev\DiscordBot\Models\Messages\Embed\Image;
use JaxkDev\DiscordBot\Models\Messages\Message;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use Zwuiix\AdvancedDiscord\botcommands\type\LoggedCommand;
use Zwuiix\AdvancedDiscord\player\DiscordManager;
use Zwuiix\AdvancedDiscord\type\botcommands\BotCommand;
use Zwuiix\AdvancedDiscord\utils\Bot;
use Zwuiix\AdvancedRank\extensions\AdvancedRankExtension;

use DaPigGuy\PiggyFactions\players\PlayerManager;
use onebone\economyapi\EconomyAPI as EcoAPI;

class InfoCommand extends LoggedCommand
{
    /**
     * @param string $sender
     * @param array $args
     * @param Message $message
     * @return void
     */
    public function onLoggedRun(string $sender, array $args, Message $message): void
    {
        if(!isset($args[0])){
            Bot::getInstance()->sendMessage($message->getChannelId(), $sender, "Veuillez faire ?info (pseudo)!");
            return;
        }
        $player=Server::getInstance()->getPlayerExact($args[0]);
        if(!$player instanceof Player){
            Bot::getInstance()->sendMessage($message->getChannelId(), $sender, "Désolée, le pseudo que vous avez saisie n'est pas connecter!");
            return;
        }
        $dPlayer=DiscordManager::getInstance()->getPlayer($player);

        $description="Discord: <@".$dPlayer->getDiscordID().">\n\n";
        $description.="Pseudonyme: `".$player->getName()."`\n";
        $description.="Ping: `".$player->getNetworkSession()->getPing()."ms`\n";

        $plugin=Server::getInstance()->getPluginManager()->getPlugin("AdvancedRank");
        if($plugin instanceof Plugin){
            $rank = AdvancedRankExtension::getInstance()->getPlayerRank($player);
            $description.="Rank: `".$rank."`\n";
        }

        $plugin=Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
        if($plugin instanceof Plugin){
            $argent = EcoAPI::getInstance()->myMoney($player);
            $description.="Argent: `".$argent."`\n";
        }

        $plugin=Server::getInstance()->getPluginManager()->getPlugin("PiggyFactions");
        if($plugin instanceof Plugin){
            $member=PlayerManager::getInstance()->getPlayer($player);
            $faction = $member?->getFaction();
            if(!is_null($faction)){
                $description.="Faction: `".$faction->getName()."`\n";
            }else{
                $description.="Faction: `...`\n";
            }
        }

        Bot::getInstance()->sendEmbedMessage($message->getChannelId(), $sender, "Voici les informations concernant **{$player->getName()}**", Embed::TYPE_ARTICLE, $description, null, null, null, "Développer par Zwuiix#0001", null, new Image("https://crafthead.net/cube/".$player->getName()));
    }

    public function prepare(): void
    {
        // TODO: Implement prepare() method.
    }
}