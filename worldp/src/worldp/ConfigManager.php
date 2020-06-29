<?php


namespace worldp;


use pocketmine\utils\Config;

class ConfigManager
{
    const PLACE = 0;
    const BREAK = 1;

    /** @var Config[] */
    private $configs;

    public function __construct()
    {
        $folder = Main::getInstance()->getDataFolder();
        $this->configs[self::PLACE] = new Config($folder."place.yml",Config::YAML);
        $this->configs[self::BREAK] = new Config($folder."break.yml",Config::YAML);
    }

    public function getConfig(int $id): ?Config
    {
        return isset($this->configs[$id]) ? $this->configs[$id] : null;
    }
}