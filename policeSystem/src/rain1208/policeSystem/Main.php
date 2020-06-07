<?php

namespace rain1208\policeSystem;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{
    /** @var Config */
    private $config;
    public function onEnable()
    {
        $this->getLogger()->info("policeSystemを起動しました");
        if (!file_exists($this->getDataFolder())) {
            mkdir($this->getDataFolder(),0744,true);
        }
        $this->config = new Config($this->getDataFolder()."Config.yml",Config::YAML);
        ConfigManager::loadConfig($this->config);

        $this->registarCommand();
    }

    private function registarCommand(): void {
    $map = $this->getServer()->getCommandMap();
    $command = ["pmode" => "rain1208\policeSystem\command\pmode",
        "ptp" => "rain1208\policeSystem\command\ptp",
        "police" => "rain1208\policeSystem\command\police",
        "addpolice" => "rain1208\policeSystem\command\policeAdd",
        "delpolice" => "rain1208\policeSystem\command\policeDel"];

    foreach ($command as $item => $class) {
        $map->register("policeSystem", new $class($this));
    }
}
    public function onDisable()
    {
        $this->getLogger()->info("policeSystemを無効化しました");
    }

}