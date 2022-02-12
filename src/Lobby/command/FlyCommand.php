<?php

declare(strict_types=1);

namespace Lobby\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player\player;
use pocketmine\utils\TextFormat;

class FlyCommand extends Command
{

    public function __construct()
    {
        parent::__construct('fly', 'Use this command to activate and deactivate the Fly');
        $this->setPermission('fly.lobby');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!$this->testPermission($sender)) {
            return;
        }

        if (!$sender instanceof Player) {
            return;
        }

        if ($sender->getAllowFlight() === false) {
            $sender->setFlying(true);
            $sender->setAllowFlight(true);
            $sender->sendMessage(TextFormat::GREEN . "You have enabled the flight!");
        } else {
            $sender->setFLying(false);
            $sender->setAllowFlight(false);
            $sender->sendMessage(TextFormat::RED . "You have disabled the flight!");
        }
    }
}
