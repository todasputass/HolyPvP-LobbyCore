<?php

namespace Lobby\listener;

use Lobby\Main;
use Lobby\session\SessionFactory;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\world\particle\FloatingTextParticle;
use skymin\bossbar\BossBarAPI;

class EventListener implements Listener
{

    public function onJoin(PlayerJoinEvent $event): void
    {
        $config = Main::getInstance()->getConfig();
        $session = SessionFactory::getSession($player = $event->getPlayer());
        if (is_null($session)) {
            return;
        }

        $session->initScoreboard();
        $session->sendWelcomeMessages();
        $session->setup();
        $session->teleportToLobbyWorld();

        foreach (SessionFactory::getSessions() as $session) {
            $session->update();
        }
        # Welcome message
        $event->setJoinMessage(TextFormat::colorize(" "));
        $pos = explode(':', $config->get('floating'));
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$pos[0], (int)$pos[1], (int)$pos[2]), new FloatingTextParticle("", "§r§eWelcome to §l" . $config->get("server-name") . ' "§r§l§6The Reborn"'), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$pos[0], (int)$pos[1] - 0.50, (int)$pos[2]), new FloatingTextParticle("", "§r§fUsa el selector para explorar las §r§emodalidades§r§f."), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$pos[0], (int)$pos[1] - 1, (int)$pos[2]), new FloatingTextParticle("", "§r§2✸ §r§a§l75% OFF SALE §r§2✸"), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$pos[0], (int)$pos[1] - 1.25, (int)$pos[2]), new FloatingTextParticle("", "§r§6¡Activo por tiempo limitado!"), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$pos[0], (int)$pos[1] - 1.75, (int)$pos[2]), new FloatingTextParticle("", "§7§ohttps://" . $config->get("server-storelink")), [$player]);

        $shoppos = explode(':', $config->get('shopfloating'));
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$shoppos[0], (int)$shoppos[1], (int)$shoppos[2]), new FloatingTextParticle("", "§r§f§k|§r §r§l§6Nueva Tienda §r§f§k|"), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$shoppos[0], (int)$shoppos[1] - 0.50, (int)$shoppos[2]), new FloatingTextParticle("", ""), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$shoppos[0], (int)$shoppos[1] - 0.75, (int)$shoppos[2]), new FloatingTextParticle("", "§r§fUtiliza el comando §6/shop §fpara adquirir"), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$shoppos[0], (int)$shoppos[1] - 1, (int)$shoppos[2]), new FloatingTextParticle("", "§r§fRangos, Crates Keys, Prefijos, Kits, y mas!"), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$shoppos[0], (int)$shoppos[1] - 1.50, (int)$shoppos[2]), new FloatingTextParticle("", "§r§fAdquiere §6Coins §fpara utilizar aqui"), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$shoppos[0], (int)$shoppos[1] - 1.75, (int)$shoppos[2]), new FloatingTextParticle("", "§r§fdesde nuestra §6web-store§f."), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$shoppos[0], (int)$shoppos[1] - 2, (int)$shoppos[2]), new FloatingTextParticle("", "§6" . $config->get("server-storelink")), [$player]);
        $player->getServer()->getWorldManager()->getDefaultWorld()?->addParticle(new Vector3((int)$shoppos[0], (int)$shoppos[1] - 2.25, (int)$shoppos[2]), new FloatingTextParticle("", ""), [$player]);

    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        # Leave message
        $event->setQuitMessage(TextFormat::colorize(" "));
    }

    public function onExhaust(PlayerExhaustEvent $event): void
    {
        # Cancel hunger update
        $event->cancel();
    }

    public function onDamage(EntityDamageEvent $event): void
    {
        # Cancel fall damage
        if ($event->getCause() === EntityDamageEvent::CAUSE_FALL) {
            $event->cancel();
            return;
        }

        if ($event->getCause() === EntityDamageEvent::CAUSE_VOID) {
            $player = $event->getEntity();

            if ($player instanceof Player) {
                $event->cancel();
                SessionFactory::getSession($player)?->teleportToLobbyWorld();
            }
            return;
        }

        if ($event->getCause() === EntityDamageEvent::CAUSE_ENTITY_ATTACK) {
            $event->cancel();
        }
    }
}


