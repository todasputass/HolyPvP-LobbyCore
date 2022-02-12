<?php

namespace Lobby\form\ArmorsForms;

use cosmicpe\form\entries\simple\Button;
use cosmicpe\form\SimpleForm;
use pocketmine\color\Color;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use Lobby\form\ArmorForm;


class LeggingsForm extends SimpleForm
{

    public function __construct()
    {
        parent::__construct("§r§7» §l§6Leggings Color §r§7«", "§r§7Select a color");
        $this->addButton(new Button("§4§lRed\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(255, 0, 0)); #red
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§l§6Orange\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(255, 123, 0)); #Orange
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§e§lYellow\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(255, 242, 0)); #yellow
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§l§2Green\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(6, 191, 0)); #Green
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§l§1Blue\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(0, 0, 240)); #blue
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§l§5Purple\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(138, 0, 230)); #purple
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§d§lPink\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(230, 0, 188)); #pink
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§0§lBlack\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(0, 0, 0)); #black
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§8§lGray\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(87, 87, 87)); #gray
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§f§lWhite\n§r§7Click to change"), function (Player $player, int $index) {
            $leggings = VanillaItems::LEATHER_PANTS();
            $leggings->setCustomColor(new Color(255, 255, 255)); #white
            $player->getArmorInventory()->setLeggings($leggings);
        });
        $this->addButton(new Button("§cBack"), function (Player $player, int $index) {
            $player->sendForm(new ArmorForm());
        });
    }
}
