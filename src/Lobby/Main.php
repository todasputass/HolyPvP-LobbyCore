<?php

namespace Lobby;

use Lobby\command\FlyCommand;
use Lobby\command\GamemodeCommand;
use Lobby\command\ShopCommand;
use Lobby\command\SpawnCommand;
use Lobby\listener\EventListener;
use Lobby\listener\ItemListener;
use Lobby\listener\SessionListener;
use Lobby\session\SessionFactory;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\event\Listener;
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
        $this->getServer()->getCommandMap()->register('shop', new ShopCommand());

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

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask (function (): void {
            $this->getServer()->broadcastMessage(" \n§r§l§aOferta de Navidad\n\n§r§7Asegurate de aprovechar nuestra oferta en\nla tienda para adquirir beneficios y mas!§a§o\n\n" . $this->getConfig()->get("server-storelink") . " \n");
        }), 60 * 20);

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask (function (): void {
            $this->getServer()->broadcastMessage(" \n§r§l§bTwitter\n\n§r§7¡Asegurate de seguirnos en Twitter para\nestar al tanto de todos nuestros eventos!§b§o\n\n" . $this->getConfig()->get("server-twitterlink") . " \n");
        }), 35 * 20);

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask (function (): void {
            $this->getServer()->broadcastMessage(" \n§r§l§6Discord\n\n§r§7¡Asegurate de entrar a nuestro servidor de\nDiscord para enterarte de noticias y eventos!§6§o\n\n" . $this->getConfig()->get("server-discordlink") . " \n");
        }), 45 * 20);

        # Send message to the logger
        $this->getLogger()->info("§r§l§6HolyPvP §r§aEnabled");
    }

    private function registerListener(Listener $listener): void
    {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }
}