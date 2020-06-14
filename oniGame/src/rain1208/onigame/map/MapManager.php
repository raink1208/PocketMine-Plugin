<?php


namespace rain1208\onigame\map;


use pocketmine\level\Level;
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
            var_dump($this->maps);
        }
    }

    public function mapExists(string $name): bool
    {
        return isset($this->maps[$name]);
    }


    public function getAllMap():array
    {
        return $this->maps;
    }

    public function setMap(string $name,Level $world): void
    {
        $config = Main::getInstance()->getConfigManager()->getConfig(ConfigManager::MAP);
        $config->set($name,["Level" => $world->getName()]);
        $config->save();
        $this->maps[$name] = new Map($name,$world);
    }

    public function getMap(string $name): ?Map
    {
        return $this->mapExists($name) ? $this->maps[$name] : null;
    }

    public function random()
    {
        $map = $this->getAllMap();
        if (empty($map)) return null;
        return $map[array_rand($map)];
    }
}