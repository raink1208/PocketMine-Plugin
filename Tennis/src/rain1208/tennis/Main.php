<?php

namespace rain1208\tennis;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(),$this);
        Entity::registerEntity(SlimeBall::class,true,["Slime","ball"]);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (!$sender instanceof Player) return true;
        switch ($command->getName()) {
            case "clearmob":
                foreach ($sender->getLevel()->getEntities() as $entity) {
                    if (!$entity instanceof Player) $entity->kill();
                }
                break;
            case "tennis":
                $racket = Item::get(ItemIds::STICK);
                $racket->setCount(2);
                $racket->setCustomName("ラケット");
                $ball = Item::get(ItemIds::SLIME_BALL);
                $ball->setCustomName("テニスボール");
                $inventory = $sender->getInventory();
                $inventory->addItem($racket);
                $inventory->addItem($ball);
                $inventory->sendContents($sender);
        }
        return true;
    }
}