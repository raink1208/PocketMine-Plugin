<?php


namespace worldp;


use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;

class EventListener implements Listener
{
    public function onBreak(BlockBreakEvent $event)
    {
        if ($event->getPlayer()->isOp()) return;
        $config = Main::getInstance()->configManager->getConfig(ConfigManager::BREAK);
        if ($config->exists($event->getPlayer()->getLevel()->getName())) {
            $data = $config->get($event->getPlayer()->getLevel()->getName());
            if (!is_array($data)) {
                $event->setCancelled(true);
                return;
            }
            $id = $event->getBlock()->getId().":".$event->getBlock()->getDamage();
            if (in_array($id,$data)) $event->setCancelled(true);
        }
    }

    public function onPlace(BlockPlaceEvent $event)
    {
        if ($event->getPlayer()->isOp()) return;
        $config = Main::getInstance()->configManager->getConfig(ConfigManager::PLACE);
        if ($config->exists($event->getPlayer()->getLevel()->getName())) {
            $data = $config->get($event->getPlayer()->getLevel()->getName());
            if (!is_array($data)) {
                $event->setCancelled(true);
                return;
            }
            $id = $event->getBlock()->getId().":".$event->getBlock()->getDamage();
            if (in_array($id,$data)) $event->setCancelled(true);
        }
    }
}