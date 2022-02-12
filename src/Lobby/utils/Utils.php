<?php

declare(strict_types=1);

namespace Lobby\utils;

use Lobby\Main;
use pocketmine\color\Color;
use pocketmine\item\Armor;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\Server;

final class Utils
{

    /**
     * @return int
     */
    public static function getNetworkPlayers(): int
    {
        $players = count(Server::getInstance()->getOnlinePlayers());
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("Servers");

        if ($plugin !== null) {

            /** @noinspection PhpUndefinedMethodInspection */
            foreach ($plugin->getAllServers() as $server) {
                $players += $server->getPlayers();
            }
        }
        return $players;
    }

    /**
     * @return int
     */
    public static function getNetworkMaxPlayers(): int
    {
        $players = Server::getInstance()->getMaxPlayers();
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("Servers");

        if ($plugin !== null) {

            /** @noinspection PhpUndefinedMethodInspection */
            foreach ($plugin->getAllServers() as $server) {
                $players += $server->getMaxPlayers();
            }
        }
        return $players;
    }

    /**
     * @param string $name
     *
     * @return int
     */
    public static function getServerPlayers(string $name): int
    {
        $players = 0;
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("Servers");

        if ($plugin !== null) {
            /** @noinspection PhpUndefinedMethodInspection */
            $server = $plugin->getServers($name); // TODO: The name of the function is that way so as not to interfere with getServer()

            if ($server !== null) {
                $players = $server->getPlayers();
            }
        }
        return $players;
    }

    /**
     * @param Player $player
     *
     * @return string
     */
    public static function getRank(Player $player): string
    {
        $rank = null;
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("GreekRanks");

        if ($plugin !== null) {
            /** @noinspection PhpUndefinedFieldInspection */
            $rankManager = $plugin->ranksManager;
            $player = $rankManager->getPlayerByXuid($player->getXuid());

            if ($player !== null && $player->isValid()) {
                if ($player->getMainRank() !== null && $player->getMainRank()->getId() !== 0) {
                    $rank = $player->getMainRank()->getFormat();
                }

                if ($player->getRank() !== null) {
                    $rank = $rank === null ? $player->getRank()->getFormat() : $rank . ' ' . $player->getRank()->getFormat();
                }
            }
        }
        return $rank ?? '§6Default';
    }

    protected static int $int_armor = 0;
    private static array $armors = [];

    public static function loadArmors(): void
    {
        self::$armors = [
            VanillaItems::LEATHER_CAP(),
            VanillaItems::LEATHER_TUNIC(),
            VanillaItems::LEATHER_PANTS(),
            VanillaItems::LEATHER_BOOTS()
        ];
    }

    /**
     * @param Player $player
     *
     * @throws \Exception
     */
    public static function randomArmorColor(Player $player): void
    {
        $armors = array_map(static function (Armor $armor): Armor {
            if (self::$int_armor >= 32) {
                self::$int_armor = 0;
            }

            $tmp = Main::$colors[self::$int_armor];
            $armor->setCustomColor(new Color((int)$tmp["r"], (int)$tmp["g"], (int)$tmp["b"]));

            return $armor;
        }, self::$armors);
        self::$int_armor++;

        $player->getArmorInventory()->setContents($armors);
    }
}