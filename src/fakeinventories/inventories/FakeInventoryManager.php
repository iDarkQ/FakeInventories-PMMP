<?php

declare(strict_types=1);

namespace fakeinventories\inventories;

final class FakeInventoryManager {

    /** @var FakeInventory[] */
    private array $playerInventories = [];
    private bool $sendPacket = true;

    public function getInventory(string $nick) : ?FakeInventory {
        return $this->playerInventories[$nick] ?? null;
    }

    public function isOpening(string $nick) : bool {
        return isset($this->playerInventories[$nick]);
    }

    public function setInventory(string $player, FakeInventory $inv) : void {
        $this->playerInventories[$player] = $inv;
    }

    public function unsetInventory(string $nick) : void {
        unset($this->playerInventories[$nick]);
    }

    public function getInventories() : array {
        return $this->playerInventories;
    }

    public function setSendPacket(bool $value) : void {
        $this->sendPacket = $value;
    }

    public function hasSendPacket() : bool {
        return $this->sendPacket;
    }
}