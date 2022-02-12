<?php

declare(strict_types=1);

namespace Lobby\command;

use CortexPE\DiscordWebhookAPI\Embed;
use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;
use Lobby\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class GamemodeCommand extends Command
{

    public function __construct()
    {
        parent::__construct('gm', 'Use this command to change your game mode');
        $this->setPermission('gm.lobby');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!$this->testPermission($sender)) {
            return;
        }

        if (!$sender instanceof Player) {
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::colorize('§r§cUse /gm (0|1|2|3])'));
            return;
        }

        switch (strtolower($args[0])) {
            case '0':
                if (!isset($args[1])) {
                    $config = Main::getInstance()->getConfig();
                    $sender->setGamemode(GameMode::SURVIVAL());
                    $sender->sendMessage(TextFormat::colorize('§r§cYou changed your game mode to §6Survival'));
                    $webhook = new Webhook($config->get("WebhookGamemodeLogs"));
                    $embed = new Embed();
                    $msg = new Message();
                    $embed->setTitle("Gamemode Change");
                    $senderName = $sender->getName();
                    $embed->setDescription("**Player:** $senderName\n**Current Gamemode:** Survival");
                    $msg->addEmbed($embed);
                    $webhook->send($msg);
                    return;
                }
                break;
            case '1':
                if (!isset($args[1])) {
                    $config = Main::getInstance()->getConfig();
                    $sender->setGamemode(GameMode::CREATIVE());
                    $sender->sendMessage(TextFormat::colorize('§r§cYou changed your game mode to §6Creative'));
                    $webhook = new Webhook($config->get("WebhookGamemodeLogs"));
                    $embed = new Embed();
                    $msg = new Message();
                    $embed->setTitle("Gamemode Change");
                    $senderName = $sender->getName();
                    $embed->setDescription("**Player:** $senderName\n**Current Gamemode:** Creative");
                    $msg->addEmbed($embed);
                    $webhook->send($msg);
                    return;
                }
                break;
            case '2':
                if (!isset($args[1])) {
                    $config = Main::getInstance()->getConfig();
                    $sender->setGamemode(GameMode::ADVENTURE());
                    $sender->sendMessage(TextFormat::colorize('§r§cYou changed your game mode to §6Adventure'));
                    $webhook = new Webhook($config->get("WebhookGamemodeLogs"));
                    $embed = new Embed();
                    $msg = new Message();
                    $embed->setTitle("Gamemode Change");
                    $senderName = $sender->getName();
                    $embed->setDescription("**Player:** $senderName\n**Current Gamemode:** Adventure");
                    $msg->addEmbed($embed);
                    $webhook->send($msg);
                    return;
                }
                break;
            case '3':
                if (!isset($args[1])) {
                    $config = Main::getInstance()->getConfig();
                    $sender->setGamemode(GameMode::SPECTATOR());
                    $sender->sendMessage(TextFormat::colorize('§r§cYou changed your game mode to §6Spectator'));
                    $webhook = new Webhook($config->get("WebhookGamemodeLogs"));
                    $embed = new Embed();
                    $msg = new Message();
                    $embed->setTitle("Gamemode Change");
                    $senderName = $sender->getName();
                    $embed->setDescription("**Player:** $senderName\n**Current Gamemode:** Spectator");
                    $msg->addEmbed($embed);
                    $webhook->send($msg);
                    return;
                }
        }
    }
}

