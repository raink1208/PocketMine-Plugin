<?php


namespace rain1208\onigame\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use rain1208\onigame\GamePlayer;
use rain1208\onigame\Main;

class StartOni extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("startoni", $owner);
        $this->setDescription("ゲームをスタートします");
        $this->setUsage("/startoni");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof GamePlayer) {
            Main::getInstance()->startGame($sender);
        } else {
            var_dump("貴方はGamePlayerではありません");
        }
    }
}