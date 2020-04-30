<?php


namespace rain1208\policeSystem\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use rain1208\policeSystem\ConfigManager;

class pmode extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("pmode", $owner);

        $this->setDescription("スペクテイターになります(police専用)");
        $this->setUsage("/pmode <on/off>");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if (ConfigManager::exists($sender->getName()) || $sender->isOp()) {
                if (isset($args[0])) {
                    if ($args[0] == "on") {
                        $sender->setGamemode(3,false);
                        $sender->sendMessage("§1スペクテイター§bにしました");
                    }
                    if ($args[0] == "off") {
                        $sender->setGamemode(0,false);
                        $sender->sendMessage("§4サバイバル§bにしました");
                    }
                } else {
                    $sender->sendMessage("/pmode <on/off>");
                }
            } else {
                $sender->sendMessage("あなたはpoliceではありません");
            }
        }
    }
}