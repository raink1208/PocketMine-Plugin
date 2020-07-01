<?php


namespace rain1208\onigame;


use pocketmine\plugin\PluginBase;
use rain1208\onigame\event\GameEventListener;
use rain1208\onigame\game\Game;
use rain1208\onigame\map\Map;
use rain1208\onigame\map\MapManager;

class Main extends PluginBase
{
    /** @var Main */
    private static $instance;

    /** @var ConfigManager */
    private $configManager;
    /** @var MapManager */
    private $mapManager;

    /** @var Game */
    private $game;

    public function onEnable()
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new GameEventListener(), $this);

        $this->configManager = new ConfigManager();
        $this->mapManager = new MapManager();

        $this->registarCommand();
    }

    private function registarCommand(): void {
        $map = $this->getServer()->getCommandMap();
        $command = [
            "setOni" => "rain1208\onigame\command\SetOni",
            "startOni" => "rain1208\onigame\command\StartOni",
            "setMap" => "rain1208\onigame\command\SetMap",
            "join" => "rain1208\onigame\command\JoinGame",
            "createoni" => "rain1208\onigame\command\CreateGame"
        ];

        foreach ($command as $item => $class) {
            $map->register("onigame", new $class($this));
        }
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function getConfigManager()
    {
        return $this->configManager;
    }

    public function getMapManager(): MapManager
    {
        return $this->mapManager;
    }

    public function createGame(): Game
    {
        return $this->game = new Game();
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function startGame(): void
    {
        $this->getGame()->startGame();
    }
}