<?php


namespace rain1208\BlackJack;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        $bj = new BlackJack();
        if ($sender instanceof Player) {
            if ($label === "bj" && isset($args[0])) {
                switch ($args[0]) {
                    case "join":
                        $bj->join($sender);
                        break;
                    case "leave":
                        $bj->leave($sender);
                        break;
                }
            }
        }
        return true;
    }
}