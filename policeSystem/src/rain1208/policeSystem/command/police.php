<?php


namespace rain1208\policeSystem\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use rain1208\policeSystem\ConfigManager;
use rain1208\policeSystem\Form\policeForm;


class police extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("police", $owner);

        $this->setDescription("police専用のformを開きます");
        $this->setUsage("/police");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if (ConfigManager::exists($sender->getName())) {
                $sender->sendForm(new policeForm(Server::getInstance()->getOnlinePlayers()));
            } else {
                $sender->sendMessage("あなたはpoliceではありません");
            }
        }
    }
}