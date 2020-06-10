<?php


namespace rain1208\onigame\command;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use rain1208\onigame\map\form\SetMapForm;

class SetMap extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("setmap", $owner);

        $this->setDescription("mapを追加します");
        $this->setUsage("/setmap");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            $sender->sendForm(new SetMapForm());
        } else {
            $sender->sendMessage("サーバー内から実行してください");
        }
    }
}