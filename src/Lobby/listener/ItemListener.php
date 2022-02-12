<?php

declare(strict_types=1);


namespace Lobby\listener;


use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\Server;

class ItemListener implements Listener
{

    public function slot_change(InventoryTransactionEvent $event): void
    {
        $player = $event->getTransaction()->getSource();

        foreach ($event->getTransaction()->getActions() as $action) {
            if (($action instanceof SlotChangeAction) && !Server::getInstance()->isOp($player->getName())) {
                $event->cancel();
            }
        }
    }
}