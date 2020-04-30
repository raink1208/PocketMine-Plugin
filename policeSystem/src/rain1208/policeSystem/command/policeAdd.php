<?php


namespace rain1208\policeSystem\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use rain1208\policeSystem\ConfigManager;

class policeAdd extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("addpolice", $owner);

        $this->setDescription("policeを増やします");
        $this->setUsage("/addpolice name");
        $this->setPermission("op");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (isset($args[0])) {
            if (Server::getInstance()->getPlayer($args[0]) !== null) {
                $player = Server::getInstance()->getPlayer($args[0])->getName();
                ConfigManager::set($player);
                $sender->sendMessage("§b".$player."をpoliceにしました");
                Server::getInstance()->getPlayer($args[0])->sendMessage("§bあなたはpoliceになりました");
            } else {
                $sender->sendMessage("プレイヤーが見つかりません");
            }

        } else {
            $sender->sendMessage("playerNameが入力されていません");
        }
    }
}