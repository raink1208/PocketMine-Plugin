<?php


namespace rain1208\code;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{
    /** @var Config */
    public $config;

    public function onEnable()
    {
        $this->config = new Config($this->getDataFolder()."code.yml",Config::YAML);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (!$sender instanceof Player) {
            $sender->sendMessage("サーバー内から使用してください");
            return true;
        }
        switch ($command->getName()) {
            case "code":
                $sender->sendForm(new CodeForm($this));
                break;
            case "addcode":
                $sender->sendForm(new AddCodeForm($this));
                break;
        }
        return true;
    }
}