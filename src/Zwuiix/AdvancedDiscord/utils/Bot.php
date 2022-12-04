<?php

namespace Zwuiix\AdvancedDiscord\utils;

use JaxkDev\DiscordBot\Models\Messages\Embed\Embed;
use JaxkDev\DiscordBot\Models\Messages\Embed\Field;
use JaxkDev\DiscordBot\Models\Messages\Embed\Footer;
use JaxkDev\DiscordBot\Models\Messages\Embed\Image;
use JaxkDev\DiscordBot\Models\Messages\Embed\Video;
use JaxkDev\DiscordBot\Models\Messages\Message;
use JaxkDev\DiscordBot\Plugin\Api;
use pocketmine\plugin\PluginException;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use JaxkDev\DiscordBot\Plugin\Main as DiscordBot;
use Zwuiix\AdvancedDiscord\data\sub\PlayersData;
use Zwuiix\AdvancedDiscord\data\sub\PluginData;

class Bot
{
    use SingletonTrait;

    public const PREFIX = "§6Discord §7» ";
    protected DiscordBot $main;

    public function __construct()
    {
        $discordBot = Server::getInstance()->getPluginManager()->getPlugin("DiscordBot");
        if($discordBot === null){
            return; //Will never happen.
        }
        if(!$discordBot instanceof DiscordBot){
            throw new PluginException("Incompatible dependency 'DiscordBot' detected.");
        }
        $this->main = $discordBot;
    }

    /**
     * @return DiscordBot
     */
    public function getBotHandler(): DiscordBot
    {
        return $this->main;
    }

    /**
     * @return Api
     */
    public function getApi(): Api
    {
        return $this->main->getApi();
    }

    /**
     * @return bool|mixed
     */
    public function getServerID(): mixed
    {
        return PluginData::get()->get("server-id");
    }

    /**
     * @param string $channelID
     * @param string $sender
     * @param string $message
     * @return void
     */
    public function sendMessage(string $channelID, string $sender, string $message): void
    {
        Bot::getInstance()->getApi()->sendMessage(new Message($channelID, null, "<@$sender> => ".$message, null, null, $this->getServerID()));
    }

    /**
     * @param string $channelID
     * @param string $sender
     * @param string|null $title
     * @param string|null $type
     * @param string|null $description
     * @param string|null $url
     * @param string|null $timestamp
     * @param int|null $color
     * @param string|null $footer
     * @param Image|null $image
     * @param Image|null $thumbnail
     * @param Video|null $video
     * @param string|null $author
     * @param array|null $field
     * @return void
     */
    public function sendEmbedMessage(string $channelID, string $sender, ?string $title = null, ?string $type = null, ?string $description = null, ?string $url = null, ?string $timestamp = null, ?int $color = null, ?string $footer = null, ?Image $image = null, ?Image $thumbnail = null, ?Video $video = null, ?string $author = null, ?array $field = []): void
    {
        Bot::getInstance()->getApi()->sendMessage(new Message($channelID, null, "<@$sender>", new Embed($title, $type, $description, $url, $timestamp, $color, new Footer($footer), $image, $thumbnail, $video, $author, $field), null, $this->getServerID()));
    }

    /**
     * @param string $channelID
     * @param string $sender
     * @return bool
     */
    public function isLogged(string $channelID, string $sender): bool
    {
        if(is_null(PlayersData::get()->getNested("dscIDS.{$sender}"))){
            $this->sendMessage($channelID, $sender, "Désolée, vous n'êtes pas enregistré, veuillez vous enregistré en réalisant la commande *?verify (pseudo)*!");
            return false;
        }
        return true;
    }
}