<?php


namespace rain1208\UIShopEco;


use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use rain1208\UIShopEco\DataBase\DataBase;
use rain1208\UIShopEco\Form\shopForm;

class Main extends PluginBase
{
    /** @var DataBase */
    private static $db;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this),$this);
        self::$db = new DataBase($this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($label === "UISshop") {
            if ($sender instanceof Player) {
                if (isset($args[0])) {
                    switch ($args[0]) {
                        
                    }
                } else {
                    $sender->sendForm(new shopForm());
                }
            }
        }
        return true;
    }

}