<?php


namespace rain1208\onigame\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use rain1208\onigame\GamePlayer;
use rain1208\onigame\Main;

class JoinGame extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("join", $owner);
        $this->setDescription("ゲームに参加します");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof GamePlayer) {
            if (Main::getInstance()->getGame() != null) {
                Main::getInstance()->getGame()->joinGame($sender);
            }
        }
    }
}