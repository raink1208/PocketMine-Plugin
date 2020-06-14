<?php


namespace rain1208\onigame\game;


use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use rain1208\onigame\GamePlayer;
use rain1208\onigame\Main;
use rain1208\onigame\map\Map;

class Game
{
    /** @var Task */
    private $gameTask;

    /** @var GamePlayer[] */
    private $players;
    private $spectates;

    private $map;

    public function setMap(Map $map): void
    {
        $this->map = $map;
        $map->reset();
    }

    public function startGame(): void
    {
        Main::getInstance()->getScheduler()->scheduleRepeatingTask($this->gameTask = new GameTask($this), 20);
        Server::getInstance()->broadcastMessage("ゲームを開始します");
    }

    public function initPlayer(Player $player)
    {
        if ($player->isOnline()) {
            $player->setGamemode(Player::SURVIVAL);
            $player->getArmorInventory()->clearAll();
            $player->getInventory()->clearAll();
            $player->setHealth($player->getMaxHealth());
            $player->setFood($player->getMaxFood());
            $player->removeAllEffects();
        }
    }

    public function joinGame(Player $player)
    {
        $this->players[$player->getName()] = $player;
        $this->initPlayer($player);
        $player->setPlaying();
        $player->sendMessage("参加しました");
    }

    public function leaveGame(Player $player)
    {
        $player->setPlaying(false);
        $player->setSpectating(false);
        $this->initPlayer($player);
    }

    public function spectate(Player $player)
    {
        $this->spectates[$player->getName()] = $player;
        $player->setSpectating();
        $player->setGamemode(Player::SPECTATOR);
    }

    public function getPlayingPlayer(): array
    {
        $players = [];
        foreach ($this->players as $player) {
            if (!$player->isPlaying()) continue;
            $players[] = $player;
        }
        return $players;
    }

    public function endGame(): void
    {
        Server::getInstance()->broadcastMessage("ゲームを終了します");
        Main::getInstance()->getScheduler()->cancelTask($this->gameTask->getTaskId());
    }
}