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