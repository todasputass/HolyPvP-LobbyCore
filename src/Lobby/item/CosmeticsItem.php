<?php

declare(strict_types=1);


namespace Lobby\item;


use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\color\Color;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
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
            0 => VanillaItems::LEATHER_CAP()->setCustomColor(new Color(138, 0, 230))->setCustomName("§r§5Staff Armor")->setLore(["§r§aClick to update your armor!"])->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1)),
            1 => VanillaItems::LEATHER_CAP()->setCustomColor(new Color(255, 242, 0))->setCustomName("§r§l§ePartner Armor")->setLore(["§r§aClick to update your armor!"])->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1)),
            2 => VanillaItems::LEATHER_CAP()->setCustomColor(new Color(236, 66, 245))->setCustomName("§r§dFamous Armor")->setLore(["§r§aClick to update your armor!"])->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1)),
            3 => VanillaItems::LEATHER_CAP()->setCustomColor(new Color(245, 66, 218))->setCustomName("§r§dYoutube Armor")->setLore(["§r§aClick to update your armor!"]),
            4 => VanillaItems::LEATHER_CAP()->setCustomColor(new Color(245, 66, 164))->setCustomName("§r§dMedia Armor")->setLore(["§r§aClick to update your armor!"]),

        ]);

        $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
            $player = $transaction->getPlayer();
            if($transaction->getItemClicked()->getCustomName() === "§r§l§ePartner Armor"){
                $helmet = VanillaItems::LEATHER_CAP();
                $helmet->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $helmet->setCustomColor(new Color(255, 242, 0)); #yellow
                $player->getArmorInventory()->setHelmet($helmet);
                $chestplate = VanillaItems::LEATHER_TUNIC();
                $chestplate->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $chestplate->setCustomColor(new Color(255, 242, 0)); #yellow
                $player->getArmorInventory()->setChestplate($chestplate);
                $leggings = VanillaItems::LEATHER_PANTS();
                $leggings->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $leggings->setCustomColor(new Color(255, 242, 0)); #yellow
                $player->getArmorInventory()->setLeggings($leggings);
                $boots = VanillaItems::LEATHER_BOOTS();
                $boots->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $boots->setCustomColor(new Color(255, 242, 0)); #yellow
                $player->getArmorInventory()->setBoots($boots);
                $player->sendMessage("§r§aYou upgraded your armor to §r§l§ePartner Armor §r§asuccessfully");
            }
            if($transaction->getItemClicked()->getCustomName() === "§r§5Staff Armor"){
                $helmet = VanillaItems::LEATHER_CAP();
                $helmet->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $helmet->setCustomColor(new Color(138, 0, 230)); #purple
                $player->getArmorInventory()->setHelmet($helmet);
                $chestplate = VanillaItems::LEATHER_TUNIC();
                $chestplate->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $chestplate->setCustomColor(new Color(138, 0, 230)); #purple
                $player->getArmorInventory()->setChestplate($chestplate);
                $leggings = VanillaItems::LEATHER_PANTS();
                $leggings->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $leggings->setCustomColor(new Color(138, 0, 230)); #purple
                $player->getArmorInventory()->setLeggings($leggings);
                $boots = VanillaItems::LEATHER_BOOTS();
                $boots->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $boots->setCustomColor(new Color(138, 0, 230)); #purple
                $player->getArmorInventory()->setBoots($boots);
                $player->sendMessage("§r§aYou upgraded your armor to §r§5Staff Armor §r§asuccessfully");
            }
            if($transaction->getItemClicked()->getCustomName() === "§r§dFamous Armor"){
                $helmet = VanillaItems::LEATHER_CAP();
                $helmet->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $helmet->setCustomColor(new Color(236, 66, 245)); #purple
                $player->getArmorInventory()->setHelmet($helmet);
                $chestplate = VanillaItems::LEATHER_TUNIC();
                $chestplate->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $chestplate->setCustomColor(new Color(236, 66, 245)); #purple
                $player->getArmorInventory()->setChestplate($chestplate);
                $leggings = VanillaItems::LEATHER_PANTS();
                $leggings->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $leggings->setCustomColor(new Color(236, 66, 245)); #purple
                $player->getArmorInventory()->setLeggings($leggings);
                $boots = VanillaItems::LEATHER_BOOTS();
                $boots->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $boots->setCustomColor(new Color(236, 66, 245)); #purple
                $player->getArmorInventory()->setBoots($boots);
                $player->sendMessage("§r§aYou upgraded your armor to §r§dFamous Armor §r§asuccessfully");
            }
            if($transaction->getItemClicked()->getCustomName() === "§r§dYoutube Armor"){
                $helmet = VanillaItems::LEATHER_CAP();
                $helmet->setCustomColor(new Color(245, 66, 218)); #purple
                $player->getArmorInventory()->setHelmet($helmet);
                $chestplate = VanillaItems::LEATHER_TUNIC();
                $chestplate->setCustomColor(new Color(245, 66, 218)); #purple
                $player->getArmorInventory()->setChestplate($chestplate);
                $leggings = VanillaItems::LEATHER_PANTS();
                $leggings->setCustomColor(new Color(245, 66, 218)); #purple
                $player->getArmorInventory()->setLeggings($leggings);
                $boots = VanillaItems::LEATHER_BOOTS();
                $boots->setCustomColor(new Color(245, 66, 218)); #purple
                $player->getArmorInventory()->setBoots($boots);
                $player->sendMessage("§r§aYou upgraded your armor to §r§dYoutube Armor §r§asuccessfully");
            }
            if($transaction->getItemClicked()->getCustomName() === "§r§dMedia Armor"){
                $helmet = VanillaItems::LEATHER_CAP();
                $helmet->setCustomColor(new Color(245, 66, 164)); #purple
                $player->getArmorInventory()->setHelmet($helmet);
                $chestplate = VanillaItems::LEATHER_TUNIC();
                $chestplate->setCustomColor(new Color(245, 66, 164)); #purple
                $player->getArmorInventory()->setChestplate($chestplate);
                $leggings = VanillaItems::LEATHER_PANTS();
                $leggings->setCustomColor(new Color(245, 66, 164)); #purple
                $player->getArmorInventory()->setLeggings($leggings);
                $boots = VanillaItems::LEATHER_BOOTS();
                $boots->setCustomColor(new Color(245, 66, 164)); #purple
                $player->getArmorInventory()->setBoots($boots);
                $player->sendMessage("§r§aYou upgraded your armor to §r§dMedia Armor §r§asuccessfully");
            }
            $transaction->getPlayer()->removeCurrentWindow();
            return $transaction->discard();
        });
        $menu->send($player);
        return ItemUseResult::SUCCESS();
    }

}