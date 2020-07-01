<?php


namespace rain1208\onigame\event;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\Server;
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

    public function changeOni(EntityDamageByEntityEvent $event)
    {
        $damager = $event->getDamager();
        $hitter = $event->getEntity();
        if ($damager instanceof GamePlayer && $hitter instanceof GamePlayer) {
            if ($damager->isOni() && $hitter->isPlaying()) {
                Server::getInstance()->broadcastMessage("鬼が交代します");
            }
        }
    }
}