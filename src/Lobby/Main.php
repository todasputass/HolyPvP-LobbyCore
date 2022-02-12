<?php

namespace Lobby;

use Lobby\command\FlyCommand;
use Lobby\command\GamemodeCommand;
use Lobby\command\NPCCommand;
use Lobby\command\SpawnCommand;
use Lobby\entity\NPCEntity;
use Lobby\listener\EventListener;
use Lobby\listener\ItemListener;
use Lobby\listener\SessionListener;
use Lobby\session\SessionFactory;
use Lobby\utils\Utils;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\event\Listener;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use pocketmine\world\World;
use muqsit\invmenu\InvMenuHandler;

class Main extends PluginBase
{
    use SingletonTrait;
    public static array $colors;

    /**
     * @throws \JsonException
     */
    protected function onLoad(): void
    {
        self::$colors = json_decode(file_get_contents($this->getFile() . "resources/colors.json"), true, 512, JSON_THROW_ON_ERROR);
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

        Utils::loadArmors();

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