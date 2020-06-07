<?php


namespace rain1208\onigame\game;


use pocketmine\scheduler\Task;
use pocketmine\Server;

class GameTask extends Task
{
    /** @var Game  */
    private $game;
    public function __construct(Game $game)
    {
        $this->game = $game;
    }


    public function onRun(int $currentTick)
    {
        //$this->sendStatus();
    }

    public function sendStatus()
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
        }
    }
}