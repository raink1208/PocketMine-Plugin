<?php


namespace rain1208\onigame\map;


use pocketmine\Server;
use rain1208\onigame\ConfigManager;
use rain1208\onigame\Main;

class MapManager
{
    private $maps = [];

    public function __construct()
    {
        $config = Main::getInstance()->getConfigManager()->getConfig(ConfigManager::MAP);
        foreach ($config->getAll() as $name => $data) {
            Server::getInstance()->loadLevel($data["Level"]);
            $world = Server::getInstance()->getLevelByName($data["Level"]);
            $this->maps[$name] = new Map($name,$world);
        }
    }

    public function mapExists(string $name): bool
    {
        return isset($this->maps[$name]);
    }


    public function getAllMap():array
    {
        $maps = [];
        foreach ($this->maps as $map) {
            $maps[] = $map;
        }
        return $maps;
    }

    public function getMap(string $name): ?Map
    {
        return $this->mapExists($name) ? $this->maps[$name] : null;
    }

}