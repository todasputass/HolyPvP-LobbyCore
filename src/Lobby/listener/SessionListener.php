<?php

declare(strict_types=1);


namespace Lobby\listener;


use Lobby\session\SessionFactory;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;

class SessionListener implements Listener
{

    /**
     * @param PlayerLoginEvent $event
     *
     * @priority LOWEST
     * @return void
     */
    public function onLogin(PlayerLoginEvent $event): void
    {
        SessionFactory::createSession($event->getPlayer());
    }

    /**
     * @param PlayerQuitEvent $event
     *
     * @priority HIGHEST
     * @return void
     */
    public function onQuit(PlayerQuitEvent $event): void
    {
        SessionFactory::removeSession($event->getPlayer());
    }
}