<?php


namespace rain1208\policeSystem\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use rain1208\policeSystem\ConfigManager;

class policeDel extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("delpolice", $owner);

        $this->setDescription("policeを減らします");
        $this->setUsage("/delpolice name");
        $this->setPermission("op");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (isset($args[0])) {
            if (Server::getInstance()->getPlayer($args[0])) {
                $player = Server::getInstance()->getPlayer($args[0])->getName();
                if (ConfigManager::exists($player)) {
                    ConfigManager::del($player);
                    $sender->sendMessage("§b".$player."のpolice権限を剥奪しました");
                    Server::getInstance()->getPlayer($player)->sendMessage("§4police権限を剥奪されました");
                }
            }
        }
    }
}