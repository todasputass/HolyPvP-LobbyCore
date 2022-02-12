<?php

declare(strict_types=1);


namespace Lobby\item;


use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\color\Color;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemUseResult;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class CosmeticsItem extends LobbyItem
{

    public function __construct()
    {
        parent::__construct(new ItemIdentifier(ItemIds::ENDER_CHEST, 0), "§r§6Cosmetics §r§7(Right Click)");
    }

    public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
        $menu->setName("§r§eChose your armor");
        $menu->getInventory()->setContents([
            0 => VanillaItems::LEATHER_CAP()->setCustomColor(new Color(255, 242, 0))->setCustomName("§r§l§ePartner Armor")->setLore(["§r§aClick to update your armor!"]),
        ]);

        $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
            $player = $transaction->getPlayer();

            if($transaction->getItemClicked()->getCustomName() === "§r§l§ePartner Armor"){
                $helmet = VanillaItems::LEATHER_CAP();
                $helmet->setCustomColor(new Color(255, 242, 0)); #yellow
                $player->getArmorInventory()->setHelmet($helmet);
                $chestplate = VanillaItems::LEATHER_TUNIC();
                $chestplate->setCustomColor(new Color(255, 242, 0)); #yellow
                $player->getArmorInventory()->setChestplate($chestplate);
                $leggings = VanillaItems::LEATHER_PANTS();
                $leggings->setCustomColor(new Color(255, 242, 0)); #yellow
                $player->getArmorInventory()->setLeggings($leggings);
                $boots = VanillaItems::LEATHER_BOOTS();
                $boots->setCustomColor(new Color(255, 242, 0)); #yellow
                $player->getArmorInventory()->setBoots($boots);
            }
            return $transaction->discard();
        });
        $menu->send($player);
        return ItemUseResult::SUCCESS();
    }

}