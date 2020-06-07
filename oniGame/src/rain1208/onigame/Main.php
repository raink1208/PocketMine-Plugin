<?php


namespace rain1208\onigame;


use pocketmine\plugin\PluginBase;
use rain1208\onigame\event\GameEventListener;

class Main extends PluginBase
{
    /** @var Main */
    private static $instance;

    /** @var ConfigManager */
    private $configManager;

    public function onEnable()
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new GameEventListener(), $this);

        $this->configManager = new ConfigManager();

        $this->registarCommand();
    }

    private function registarCommand(): void {
        $map = $this->getServer()->getCommandMap();
        $command = [
            "setOni" => "rain1208\onigame\command\SetOni",
            "startOni" => "rain1208\onigame\command\StartOni"
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


}