<?php

declare(strict_types=1);

namespace Lobby\command;

use Lobby\session\SessionFactory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class SpawnCommand extends Command
{

    public function __construct()
    {
        parent::__construct('spawn', 'Use it to teleport to the world spawn', "", ["hub", "lobby"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if ($sender instanceof Player) {
            SessionFactory::getSession($sender)?->teleportToLobbyWorld();
        }
    }

}
