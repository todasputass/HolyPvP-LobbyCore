<?php

declare(strict_types=1);

namespace Lobby\session;

use Lobby\Main;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SessionFactory
{

    /** @var Session[] */
    static private array $sessions = [];

    /**
     * @return Session[]
     */
    public static function getSessions(): array
    {
        return self::$sessions;
    }

    public static function getSession(Player $player): ?Session
    {
        return self::$sessions[$player->getName()] ?? null;
    }

    public static function createSession(Player $player): void
    {
        self::$sessions[$player->getName()] = new Session(
            $player,
            SessionScoreboard::create($player, TextFormat::colorize(Main::getInstance()->getConfig()->get('scoreboard.title')))
        );
    }

    public static function removeSession(Player $player): void
    {
        unset(self::$sessions[$player->getName()]);
    }
}
