<?php


namespace rain1208\onigame;


use pocketmine\Player;

class GamePlayer extends Player
{
    public function initPlayer():void
    {
        $config = Main::getInstance()->getConfigManager()->getConfig(ConfigManager::PLAYERS);
        if (empty($config->get($this->getName()))) {
            $data = [
                "isOni" => false,
                "isPlaying" => false,
                "isSpectating" => false
            ];
            $config->set($this->getName(),$data);
            $config->save();
        } else {
            $this->set("isOni",false);
            $this->set("isPlaying",false);
            $this->set("isSpectating",false);
        }
    }

    public function getAllData(): array
    {
        return Main::getInstance()->getConfigManager()->getConfig(ConfigManager::PLAYERS)->getAll()[$this->getName()];
    }

    public function get($key)
    {
        return $this->getAllData()[$key];
    }

    public function set($key,$val)
    {
        $data = $this->getAllData();
        $data[$key] = $val;
        $config = Main::getInstance()->getConfigManager()->getConfig(ConfigManager::PLAYERS);
        $config->set($this->getName(),$data);
        $config->save();
    }

    public function isPlaying(): bool
    {
        return $this->get("isPlaying");
    }

    public function setPlaying(bool $bool)
    {
        $this->set("isPlaying",$bool);
    }

    public function isOni(): bool
    {
        return $this->get("isOni");
    }

    public function setOni(bool $bool = true)
    {
        $this->set("isOni",$bool);
    }

    public function isSpectating(): bool
    {
        return $this->get("isSpectating");
    }

    public function setSpectating(bool $bool = true)
    {
        $this->set("isSpectating",$bool);
        $this->getLevel()->getName();
    }
}