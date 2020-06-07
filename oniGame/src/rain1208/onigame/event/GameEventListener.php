<?php


namespace rain1208\onigame\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerLoginEvent;
use rain1208\onigame\GamePlayer;

class GameEventListener implements Listener
{
    public function onPlayerCreation(PlayerCreationEvent $event)
    {
        $event->setPlayerClass(GamePlayer::class);
    }
    public function onJoin(PlayerLoginEvent $event) {
        $event->getPlayer()->initPlayer();
    }
}