<?php

namespace Lobby;

use Lobby\command\FlyCommand;
use Lobby\command\GamemodeCommand;
use Lobby\command\SpawnCommand;
use Lobby\listener\EventListener;
use Lobby\listener\ItemListener;
use Lobby\listener\SessionListener;
use Lobby\session\SessionFactory;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\event\Listener;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

class Main extends PluginBase
{
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        # Setup config
        $this->saveResource("config.yml");
        # Add a Custom MOTD
        $this->getServer()->getNetwork()->setName(TextFormat::colorize($this->getConfig()->get("server-motd")));
        # Register commands
        $this->getServer()->getCommandMap()->register('spawn', new SpawnCommand());
        $this->getServer()->getCommandMap()->register('fly', new FlyCommand());
        $this->getServer()->getCommandMap()->register('gm', new GamemodeCommand());


        # Register events
        $this->registerListener(new EventListener());
        $this->registerListener(new ItemListener());
        $this->registerListener(new SessionListener());

        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }

        # Setup task
        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function (): void {
            foreach (SessionFactory::getSessions() as $session) {
                $session->update();
            }
        }), 1);

        # Send message to the logger
        $this->getLogger()->info("LobbyCore Enabled");
    }

    private function registerListener(Listener $listener): void
    {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }
}