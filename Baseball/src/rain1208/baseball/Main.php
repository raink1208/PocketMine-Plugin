<?php


namespace rain1208\baseball;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Stick;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(),$this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($label) {
            case "bat":
                if ($sender instanceof Player) {
                    $item = new Stick(1);
                    $item->setCustomName("バット");
                    $sender->getInventory()->setItemInHand($item);
                }
                break;
        }
        return true;
    }
}