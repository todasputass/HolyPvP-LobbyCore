<?php

declare(strict_types=1);

namespace Lobby\session;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;

class SessionScoreboard
{

    /** @var string */
    private string $title;
    /** @var ScorePacketEntry[] */
    private array $lines;

    /** @var bool */
    private bool $spawned;
    /** @var Player */
    private Player $player;

    /**
     * SessionScoreboard construct.
     *
     * @param Player $player
     * @param string $title
     */
    public function __construct(Player $player, string $title)
    {
        $this->title = $title;
        $this->lines = [];
        $this->spawned = false;
        $this->player = $player;
    }

    /**
     * @param Player $player
     * @param string $title
     *
     * @return self
     */
    public static function create(Player $player, string $title): self
    {
        return new self($player, $title);
    }

    /**
     * @return bool
     */
    public function isSpawned(): bool
    {
        return $this->spawned;
    }

    public function init(): void
    {
        if ($this->spawned) {
            return;
        }
        $pk = SetDisplayObjectivePacket::create(
            SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR,
            $this->player->getName(),
            $this->title,
            'dummy',
            SetDisplayObjectivePacket::SORT_ORDER_ASCENDING
        );
        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
        $this->spawned = true;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function remove(): void
    {
        if (!$this->spawned) {
            return;
        }
        $pk = RemoveObjectivePacket::create(
            $this->player->getName()
        );
        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
        $this->spawned = false;
    }

    /**
     * @param string   $line
     * @param int|null $id
     */
    public function addLine(string $line, ?int $id = null): void
    {
        $id = $id ?? count($this->lines);

        $entry = new ScorePacketEntry();
        $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;

        if (isset($this->lines[$id])) {
            $pk = new SetScorePacket();
            $pk->entries[] = $this->lines[$id];
            $pk->type = SetScorePacket::TYPE_REMOVE;
            $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
            unset($this->lines[$id]);
        }
        $entry->scoreboardId = $id;
        $entry->objectiveName = $this->getPlayer()->getName();
        $entry->score = $id;
        $entry->actorUniqueId = $this->getPlayer()->getId();
        $entry->customName = $line;
        $this->lines[$id] = $entry;

        $pk = new SetScorePacket();
        $pk->entries[] = $entry;
        $pk->type = SetScorePacket::TYPE_CHANGE;
        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
    }

    /**
     * @param int $id
     */
    public function removeLine(int $id): void
    {
        if (isset($this->lines[$id])) {
            $line = $this->lines[$id];
            $pk = new SetScorePacket();
            $pk->entries[] = $line;
            $pk->type = SetScorePacket::TYPE_REMOVE;
            $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
            unset($this->lines[$id]);
        }
    }

    public function clear(): void
    {
        $pk = new SetScorePacket();
        $pk->entries = $this->lines;
        $pk->type = SetScorePacket::TYPE_REMOVE;
        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
        $this->lines = [];
    }
}