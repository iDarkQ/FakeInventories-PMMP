<?php

declare(strict_types=1);

namespace fakeinventories\listeners\inventory;

use fakeinventories\inventories\FakeInventory;
use fakeinventories\inventories\FakeInventoryManager;
use fakeinventories\Main;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\transaction\action\SlotChangeAction;

class InventoryTransactionListener implements Listener {

    /**
     * @param InventoryTransactionEvent $e
     * @priority NORMAL
     * @ignoreCancelled true
     */

    public function onTransaction(InventoryTransactionEvent $e) : void {
        $transaction = $e->getTransaction();
        $player = $transaction->getSource();
        $inventories = $transaction->getInventories();
        $actions = $transaction->getActions();

        $fakeInventory = Main::getInstance()->getFakeInventoryManager()->getInventory($player->getName());

        foreach($inventories as $inventory) {
            if($inventory instanceof FakeInventory) {
                if($fakeInventory === null) {
                    $e->cancel();
                    return;
                }

                foreach($actions as $action) {
                    if(!$action instanceof SlotChangeAction || $action->getInventory() !== $inventory)
                        continue;

                    $fakeInventory->onTransaction($player, $action->getSourceItem(), $action->getTargetItem(), $action->getSlot()) ? $e->cancel() : $e->uncancel();
                }
            }
        }
    }
}