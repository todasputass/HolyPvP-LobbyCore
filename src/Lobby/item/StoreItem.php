<?php

namespace Lobby\item;

use Lobby\Main;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemUseResult;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class StoreItem extends LobbyItem
{

    public function __construct()
    {
        parent::__construct(new ItemIdentifier(ItemIds::CHEST, 0), "§r§6Holy Store §r§7(Right Click)");
    }

    public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
        $menu->setName("§r§8Servers");
        $menu->getInventory()->setContents([
            0 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            1 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            7 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            8 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            9 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            17 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            18 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            19 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            25 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
            26 => VanillaBlocks::GLASS_PANE()->asItem()->setCustomName(" "),
        ]);

        $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
            $player = $transaction->getPlayer();

            if($transaction->getItemClicked()->getCustomName() === "HCF"){
                $player->transfer("greekmc.net", 19132);
            }
            return $transaction->discard();
        });
        $menu->send($player);
        return ItemUseResult::SUCCESS();
    }

}
{

}