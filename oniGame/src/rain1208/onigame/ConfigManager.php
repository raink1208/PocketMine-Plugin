<?php


namespace rain1208\onigame;

use pocketmine\utils\Config;

class ConfigManager
{
    private $configs = [];

    public function __construct()
    {
        $f = Main::getInstance()->getDataFolder();
        $this->configs[0] = new Config($f."map.json",Config::JSON);
        $this->configs[1] = new Config($f."player.json",Config::JSON);
    }

    public function getConfig(int $n): ?Config
    {
        return isset($this->configs[$n]) ? $this->configs[$n] : null;
    }
}