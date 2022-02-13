<?php
declare(strict_types=1);

namespace Lobby\item;


use Lobby\Main;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemUseResult;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;

class ServerSelectorItem extends LobbyItem
{

    public function __construct()
    {
        parent::__construct(new ItemIdentifier(ItemIds::COMPASS, 0), "§r§6Server Selector §r§7(Right Click)");
    }

    public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_DOUBLE_CHEST);
        $menu->setName("§r§8Servers");
        $menu->getInventory()->setContents([
            20 => VanillaItems::DIAMOND_SWORD()->setCustomName("§r§l§6HCF §r§a*$50 PAYPAL*")->setLore(["§r§7✸ §r§ePlayers: §f0 \n\n§r§7✸ §r§eMap Kit: §fProt 2, Sharp 2 \n§r§7✸ §r§eFaction Size: §f8 Man \n§r§7✸ §r§eSOTW§7 » §fDomingos, 4PMEST."]),
            22 => VanillaItems::BOW()->setCustomName("§r§l§6Kits")->setLore(["§r§7✸ §r§ePlayers: §f0 \n\n§r§7✸ §r§eMap Kit: §fProt 2, Sharp 2 \n§r§7✸ §r§eFaction Size: §f20 Man \n§r§7✸ §r§eSOTW§7 » §f11/12/21 3PM EST."]),
            24 => VanillaItems::HEALING_SPLASH_POTION()->setCustomName("§r§l§6Practice")->setLore(["§r§7✸ §r§ePlayers: §f0 \n\n§r§7✸ §r§eUnranked, Ranked & Parties\n§r§7✸ §r§eAutomated Events and Tournaments\n§r§7✸ §r§eTeamfighting Simulator"]),
        ]);

        $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
            $player = $transaction->getPlayer();

            if($transaction->getItemClicked()->getCustomName() === "§r§l§6HCF §r§a*$50 PAYPAL*"){
                $config = Main::getInstance()->getConfig();
                $player->transfer($config->get("HCF-IP"), $config->get("HCF-PORT"));
            }
            return $transaction->discard();
        });
        $menu->send($player);
        return ItemUseResult::SUCCESS();
    }

}