<?php


namespace rain1208\onigame;

use pocketmine\utils\Config;

class ConfigManager
{
    private $configs = [];
    const MAP = 0;
    const PLAYERS = 1;

    public function __construct()
    {
        $f = Main::getInstance()->getDataFolder();
        $this->configs[self::MAP] = new Config($f."map.json",Config::JSON);
        $this->configs[self::PLAYERS] = new Config($f."player.json",Config::JSON);
    }

    public function getConfig(int $n): ?Config
    {
        return isset($this->configs[$n]) ? $this->configs[$n] : null;
    }
}