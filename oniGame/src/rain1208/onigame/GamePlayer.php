<?php


namespace rain1208\onigame;


use pocketmine\Player;

class GamePlayer extends Player
{
    public function initPlayer():void
    {
        $config = Main::getInstance()->getConfigManager()->getConfig(1);
        if (empty($config->get($this->getName()))) {
            $data = [
                "isOni" => false,
                "isPlaying" => false,
            ];
            $config->set($this->getName(),$data);
            $config->save();
        } else {
            $config->get($this->getName())->set("isOni",false);
            $config->get($this->getName())->set("isPlaying",false);
        }
    }

    public function getAllData(): array
    {
        return Main::getInstance()->getConfigManager()->getConfig(1)->getAll()[$this->getName()];
    }

    public function get($key)
    {
        return $this->getAllData()[$key];
    }

    public function set($key,$val)
    {
        $data = $this->getAllData();
        $data[$key] = $val;
        $config = Main::getInstance()->getConfigManager()->getConfig(1);
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
}