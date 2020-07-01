<?php


namespace rain1208\onigame\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use rain1208\onigame\Main;

class CreateGame extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("createoni", $owner);
        $this->setDescription("鬼ごっこのゲームを作成します");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        Main::getInstance()->createGame();
        Server::getInstance()->broadcastMessage("ゲームが作成されました");
    }
}