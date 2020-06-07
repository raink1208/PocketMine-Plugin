<?php


namespace rain1208\onigame\game;


use pocketmine\Player;
use pocketmine\Server;
use rain1208\onigame\Main;
use rain1208\onigame\map\Map;

class Game
{
    private $gameTask;

    /** @var Player[] */
    private $players;
    private $spectates;

    private $map;
    private $game;

    private $oni;


    public function __construct(Map $map,Player $oni)
    {
        $this->oni = $oni;
        $this->map = $map;
        $map->reset();
        Main::getInstance()->getScheduler()->scheduleRepeatingTask($this->gameTask = new GameTask($this), $sec = 20);
    }

    public function initPlayer(Player $player,bool $join = true)
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
        $this->initPlayer($player,false);
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
}