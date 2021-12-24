<?php

declare(strict_types=1);

namespace fakeinventories\utils;

use fakeinventories\Main;
use Exception;
use pocketmine\scheduler\ClosureTask;

final class TaskUtil {

    private function __construct() {}

    public static function sendDelayedTask(callable $callback, int $delay = 0) : void {
        Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function() use ($callback) : void {
            try {
                $callback();
            }catch(Exception $exception) {
                Main::getInstance()->getLogger()->error("Task Error: " . $exception);
            }
        }), $delay);
    }

    public static function sendTask(callable $callback) : void {
        Main::getInstance()->getScheduler()->scheduleTask(new ClosureTask(function() use ($callback) : void {
            try {
                $callback();
            }catch(Exception $exception) {
                Main::getInstance()->getLogger()->error("Task Error: " . $exception);
            }
        }));
    }
}