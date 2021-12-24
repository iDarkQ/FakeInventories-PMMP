<?php

declare(strict_types=1);

namespace fakeinventories;

use fakeinventories\inventories\FakeInventoryManager;
use fakeinventories\listeners\inventory\InventoryTransactionListener;
use fakeinventories\listeners\packet\DataPacketReceiveListener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    private static self $instance;

    private FakeInventoryManager $fakeInventoryManager;

    public function onEnable() : void {
        self::$instance = $this;

        $this->fakeInventoryManager = new FakeInventoryManager();

        $this->initListeners();
    }

    private function initListeners() : void {
        $listeners = [
            new InventoryTransactionListener(),
            new DataPacketReceiveListener()
        ];

        foreach($listeners as $listener) {
            $this->getServer()->getPluginManager()->registerEvents($listener, $this);
        }
    }

    public static function getInstance() : self {
        return self::$instance;
    }

    public function getFakeInventoryManager() : FakeInventoryManager {
        return $this->fakeInventoryManager;
    }
}