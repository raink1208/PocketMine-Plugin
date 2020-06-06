<?php


namespace rain1208\onigame\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;

class GameEventListener implements Listener
{
    public function onJoin(PlayerLoginEvent $event) {
        $event->getPlayer()->initPlayer();
    }
}