<?php

declare(strict_types=1);

namespace Lobby\session;

use Exception;
use Lobby\item\CosmeticsItem;
use Lobby\item\StoreItem;
use Lobby\item\EnderPearlBuffItem;
use Lobby\item\ServerSelectorItem;
use Lobby\Main;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Session
{

    /**
     * Session construct.
     *
     * @param Player            $player
     * @param SessionScoreboard $scoreboard
     * @param bool              $rainbowArmor
     */
    public function __construct(
        private Player            $player,
        private SessionScoreboard $scoreboard,
        private bool              $rainbowArmor = false
    ) {}

    /**
     * @param bool $value
     */
    public function setRainbowArmor(bool $value): void
    {
        $this->rainbowArmor = $value;
    }

    public function sendWelcomeMessages(): void
    {
        $config = Main::getInstance()->getConfig();
        $join_message = [
            TextFormat::colorize("&r&f"),
            TextFormat::colorize("           §r§fWelcome to " . $config->get("server-name") . " §6Network"),
            TextFormat::colorize("§r§f✪ &r&cStore:§r§f " . $config->get("server-storelink")),
            TextFormat::colorize("§r§f✪ &r&aTeamSpeak:§r§f " . $config->get("server-discordlink")),
            TextFormat::colorize("§r§f✪ &r&cDiscord:§r§f " . $config->get("server-twitterlink")),
            TextFormat::colorize("§r§f✪ &r&aCoins:§r§f 0"),
            TextFormat::colorize("&r&f"),
            TextFormat::colorize("&r&f"),
            TextFormat::colorize("&r&e     You have been auto-logged as premiun user"),
            TextFormat::colorize("&r&f"),
        ];
        $this->player->sendMessage(implode("\n", $join_message));
        $this->player->sendTitle("§r§aAuto-Logged");
        $this->player->sendSubTitle("§r§eThanks for playing with us :D!");
    }

    public function setup(): void
    {
        $hunger_manager = $this->player->getHungerManager();
        $hunger_manager->setFood($hunger_manager->getMaxFood());

        $this->player->getInventory()->clearAll();
        $this->player->getEffects()->clear();

        $this->player->setGamemode(GameMode::ADVENTURE());
        $this->player->setHealth($this->player->getMaxHealth());

        $this->player->getInventory()->setItem(8, new CosmeticsItem());
        $this->player->getInventory()->setItem(7, new StoreItem());
        $this->player->getInventory()->setItem(0, new ServerSelectorItem());
        $this->player->getInventory()->setItem(1, new EnderPearlBuffItem());
    }

    public function teleportToLobbyWorld(): void
    {
        $this->player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()?->getSafeSpawn());
    }

    public function initScoreboard(): void
    {
        $this->scoreboard->init();
    }

    /**
     * @throws \Exception
     */
    public function update(): void
    {
        $config = Main::getInstance()->getConfig();

        # Scoreboard
        $this->scoreboard->clear();
        foreach ($config->get('scoreboard.lines') as $content) {
            $content = str_replace(['{players_count}', '{player_nick}'], [count(Server::getInstance()->getOnlinePlayers()), $this->player->getName()], $content);
            $this->scoreboard->addLine(TextFormat::colorize($content));
        }
    }

    /**
     * @return bool
     */
    public function isRainbowArmor(): bool
    {
        return $this->rainbowArmor;
    }
}